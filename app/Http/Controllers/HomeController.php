<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Language;
use App\Post;
use App\Review;
use App\Service;
use App\Zipcode;
use GoogleRecaptchaToAnyForm\GoogleRecaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;
use Spatie\Valuestore\Valuestore;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $settings = Valuestore::make(storage_path('app/settings.json'));

        $posts = Post::query();
        $posts = $posts->join('users', 'users.id', '=', 'posts.user_id');
        if($request->service){
            $service = Service::where('name', 'like', $request->service)->first();
            if (is_null($service)) {
                $posts = $posts->where('posts.tag', 'like', $request->service);
            } else {
                $posts = $posts->whereHas('services', function($q) use($request, $service){
                    $q->where('service_id', $service ? $service->id : 'n/a');
                });
            }
        }
        if($request->country_id){
            $posts = $posts->where('posts.country_id',$request->country_id);
        }else{
            $country = Country::where('name_code', 'US')->first();
            if($country)
                $posts = $posts->where('posts.country_id',$country->id);
        }

        if($request->location_type == 'city' && $request->location){
            $city = City::where('name', 'like', $request->location)->first();
            $posts = $posts->where('posts.city_id', $city ? $city->id : 'n/a');
        }
        if($request->location_type == 'zipcode' && $request->location){
            $zipcode = Zipcode::where('code', 'like', $request->location)->first();
            $posts = $posts->where('posts.zipcode_id', $zipcode ? $zipcode->id : 'n/a');
        }
        if($request->language_ids){
            $posts = $posts->whereHas('languages', function($q) use($request){
                $q->whereIn('language_id', $request->language_ids);
            });
        }
        if($request->gender){
            $posts = $posts->where('users.gender', $request->gender);
        }
        if($request->hourly_rate_min){
            $posts = $posts->where('hourly_rate', '>=', $request->hourly_rate_min);
        }
        if($request->hourly_rate_max){
            $posts = $posts->where('hourly_rate', '<=', $request->hourly_rate_max);
        }
        if($request->experience_years){
            if($request->experience_years  == 1){
                $posts = $posts->whereBetween('experience', [1, 5]);
            }else if($request->experience_years  == 6){
                $posts = $posts->whereBetween('experience', [5, 10]);
            }else if($request->experience_years  == 11){
                $posts = $posts->where('experience', '>=', 10);
            }
        }

        $posts = $posts->select('posts.*', 'users.name as user_name',
            'users.profile_photo as profile_photo',
            'users.profile_photo_verified as profile_photo_verified');
        
        if(!$request->sort_by){
            $posts = $posts->orderBy('posts.featured', 'desc')
                ->orderBy('id', 'desc');
        }elseif ($request->sort_by == 'cph_l_to_h'){
            $posts = $posts->orderBy('posts.hourly_rate', 'asc');
        }elseif ($request->sort_by == 'exp_h_to_l'){
            $posts = $posts->orderBy('posts.experience', 'desc');
        }elseif ($request->sort_by == 'exp_l_to_h'){
            $posts = $posts->orderBy('posts.experience', 'asc');
        }

        $posts = $posts->whereNotNull('verified_at')
            ->paginate(10);

//        dd($posts->total());

        return view('index', [
            'settings'=> $settings,
            'posts' => $posts
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post_detail($id)
    {
        $post = Post::whereNotNull('verified_at')
            ->with('user')
            ->with('languages')
            ->with('services')
            ->with('city')
            ->findOrFail($id);
        $profile_photo = null;
        $post_rating = 0;
        $reviews = DB::table('reviews')
            ->selectRaw('sum(rate) as sum, count(*) as count')
            ->where('post_id', $id)
            ->first();
        $post_rating = [0,0];

        if($reviews->sum && $reviews->count ){
            $post_rating = [
                floor($reviews->sum / $reviews->count),
                $reviews->sum / $reviews->count - floor($reviews->sum / $reviews->count)
            ];
        }

        if(!$post->user)   abort(404);

        if($post->user){
            $get_profile_photo = $post->user->profile_photo_verified && $post->user->profile_photo
                ? get_profile_photo($post->user->profile_photo) : null;
            $profile_photo = $get_profile_photo && $get_profile_photo['original']
                ? $get_profile_photo['original'] : '/images/no-user.png';
        }


        return view('post-detail', [
            'post' => $post,
            'profile_photo' => $profile_photo,
            'reviews' => $reviews,
            'post_rating' => $post_rating
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function provide_service()
    {
        return view('provide-service');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit_service()
    {
        $post = auth()->user()->post;
        if(!$post){
            return redirect()->to('/provide-service');
        }
        return view('edit-service', compact('post'));
    }
}
