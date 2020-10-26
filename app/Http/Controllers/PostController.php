<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Post;
use App\Review;
use App\ServiceTag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::withTrashed()->orderBy('id', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param StorePost $request
     * @return array
     */
    public function store(StorePost $request)
    {
        $country = Country::find($request->country_id);
        $zipcode = $country->zipcodes->find($request->zipcode_id);
        $city = $zipcode->city;
        $state = $city->state;
        if($zipcode)
        {
            $filename = null;
            $request['user_id'] = auth()->user()->id;
            $request['city_id'] = $city->id;
            $request['state_id'] = $state ? $state->id : null;
            $post = Post::create($request->all());
            $post->languages()->sync($request->spoken_languages);
            $post->services()->sync($request->services_offer);
            if($request->file('profile_photo')){
                $filename = upload_profile_photo($request->file('profile_photo'), auth()->user());
            }
            auth()->user()->update([
                'profile_photo' => $filename ? $filename : auth()->user()->profile_photo,
                'profile_photo_verified' => $filename ? false : auth()->user()->profile_photo_verified,
                'referrer_id' => $request->referrer_id,
                'gender' => $request->gender
            ]);
            session()->flash('success', 'You have successfully provided service.
                After admin verification it will be visible soon');
        }
        else
        {
            session()->flash('error', 'Zipcode does not belong to the country');
            return back()->withInput();
        }

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * @param UpdatePost $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePost $request, $id)
    {
        $post = Post::findOrFail($id);
        if(!Auth::user()->getRoleNames() && Auth::user()->id != $post->user_id){
            abort(403, 'Unauthorized access');
        }
        $tag = $request['tag'];
        ServiceTag::firstOrCreate(['name' => $tag, 'slug'=> Str::slug($tag)]);
        $country = Country::find($request->country_id);
        $zipcode = $country->zipcodes->find($request->zipcode_id);
        $city = $zipcode->city;
        $state = $city->state;
        if($zipcode)
        {
            $request['city_id'] = $city->id;
            $request['state_id'] = $state ? $state->id : null;
            $update = $post->update($request->all());
            $post->languages()->sync($request->spoken_languages);
            $post->services()->sync($request->services_offer);
            $post->user()->update([
                'referrer_id' => $request->referrer_id,
                'gender' => $request->gender
            ]);
            if($update){
                // if user is not admin panel user then update post reupdate_at column
                if(!count(Auth::user()->getRoleNames())){
                    $post->update(['reupdated_at' => time()]);
                }
                session()->flash('success', 'Updated');
            }else{
                session()->flash('error', 'Error. not updated!!!');
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        session()->flash('success', 'Post was deleted!');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        session()->flash('success', 'Post was restored');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['verified_at' => now(), 'reupdated_at' => null]);
        session()->flash('success', 'Post was verified');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function re_verify($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['verified_at' => now(), 'reupdated_at' => null]);
        session()->flash('success', 'Post was re-verified');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unverify($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['verified_at' => null, 'reupdated_at' => null]);
        session()->flash('success', 'Post was unverified');
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function post_reviews(Request $request, $id)
    {
        $request->validate([
            'page' => 'required|integer'
        ]);
        $resp = [];
        $skip = $request->page - 1;
        $reviews = Review::where('post_id', $id)->skip($skip * 5)->take(5)
            ->with('user')
            ->orderBy('id', 'desc')->get();

        foreach($reviews as $review){
            $fetch_profile_photo = $review->user && $review->user->profile_photo && $review->user->profile_photo_verified
                ? get_profile_photo($review->user->profile_photo) : null;
            $filename = $fetch_profile_photo && $fetch_profile_photo['thumbnail']
                ? $fetch_profile_photo['thumbnail'] : '/images/no-user.png';

            $resp[] = [
                'profile_photo' => $filename,
                'user_name' => $review->user ? $review->user->name : '',
                'rate' => $review->rate,
                'text' => $review->text,
                'created_at' => $review->created_at->diffForHumans()
            ];
        }

        return $resp;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_featured(Request $request, $id)
    {
        $request->validate(['featured' => 'sometimes|nullable|integer|max:1']);
        $post = Post::withTrashed()->findOrFail($id);
        $update = $post->update(['featured' => $request->featured ? 1 : 0]);
        if($update)
            $request->session()->flash('success', 'Saved!!!');
        return back();
    }
}
