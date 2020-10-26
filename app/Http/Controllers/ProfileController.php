<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use function foo\func;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $profile_photo = auth()->user()->profile_photo_verified ?  auth()->user()->profile_photo :  auth()->user()->old_profile_photo;

        if (is_null($profile_photo) || strlen($profile_photo) < 10) {
            $profile_photo = '/images/no-user.png';
        } else {
            $profile_photo = Storage::disk('s3')
                ->url('profile-photos/original/' . $profile_photo);
        }
        return view('home', [
            'profile_photo' => $profile_photo
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45'
        ]);

        $update = Auth::user()->update($request->all());
        if ($update) {
            $request->session()->flash('success', 'Account was updated!');
        }
        return back();
    }
    public function update_gender(Request $request)
    {
        $request->validate([
            'gender' => 'required|string|max:45'
        ]);

        $update = Auth::user()->update($request->all());
        if ($update) {
            $request->session()->flash('success', 'Account was updated!');
        }
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_password(Request $request)
    {
        $request->validate([
            'current' => 'required|string',
            'password' => 'required|string|max:15|min:8|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        if (Hash::check($request->current, Auth::user()->password)) {
            Auth::user()->password = bcrypt($request->password);
            $request->session()->flash('success', 'Password was updated!');
        } else {
            $request->session()->flash('error', 'Current password not match');
        }

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profile_photo(Request $request)
    {

        $request->validate([
            'image' => 'required|image|max:15000|mimes:jpg,jpeg,png' .
                '|dimensions:min_width=25,min_height=25'
        ]);

        $image = Image::make($request->file('image'));
        $name = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $filename = md5(Auth::user()->id) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $s3Path = '/profile-photos/original/' . $filename;
        $s3PathThumb = '/profile-photos/thumbnail/' . $filename;
        $localPath = storage_path('app/temp/' . $filename);
        $localPathThumb = storage_path('app/temp/thumbnail-' . $filename);
        $image->resize(250, null, function ($c) {
            $c->aspectRatio();
        });

        $image = $image->save($localPath, 60);
        if ($image) {
            // user current profile photo
            $current_photo = Auth::user()->profile_photo;
            $thumbnail = Image::make($localPath)->resize(50, null, function ($con) {
                $con->aspectRatio();
            })->save($localPathThumb);

            Storage::disk('s3')->put($s3Path, file_get_contents($localPath));
            Storage::disk('s3')->put($s3PathThumb, file_get_contents($localPathThumb));
            // delete temp images
            unlink($localPath);
            unlink($localPathThumb);
            // update user profile photo
            Auth::user()->update([
                'profile_photo' => $filename,
                'old_profile_photo' => Auth::user()->profile_photo,
                'profile_photo_verified' => null
            ]);
            $request->session()->flash('success', 'Profile photo updated. It will be visible after admin verification');
            if ($current_photo) {
                // if (Storage::disk('s3')->exists('/profile-photos/original/' . $current_photo)) {
                //     Storage::disk('s3')->delete('/profile-photos/original/' . $current_photo);
                // }
                // if (Storage::disk('s3')->exists('/profile-photos/thumbnail/' . $current_photo)) {
                //     Storage::disk('s3')->delete('/profile-photos/thumbnail/' . $current_photo);
                // }
            }
        } else {
            $request->session()->flash('error', 'Profile photo not updated.!!!');
        }

        return back();
    }
}
