<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::withTrashed()->paginate(10);

        return view('admin.users.index')->with([
            'users' => $users,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'email' => 'required|email|unique:users,email|max:255|indisposable',
            'password' => 'required|string|confirmed|min:8|max:15',
            'gender' => 'sometimes|nullable|string|in:male,female',
            'profile_photo' => 'sometimes|nullable|image|max:2048|mimes:jpg,jpeg,png'.
                '|dimensions:min_width=25,min_height=25'
        ]);
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->all());
        if($user)
        {
            if($request->profile_photo){
                $filename = upload_profile_photo($request->file('profile_photo'), $user);
                // update user profile photo
                if($filename) $user->update(['profile_photo' => $filename]);
            }
            $user->sendEmailVerificationNotification();
            session()->flash('success', 'New user created');
        }
        else
        {
            session()->flash('error', 'New user was not created');
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
        $user = User::withTrashed()->findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->withTrashed()->firstOrFail();

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'gender' => 'sometimes|nullable|string|in:male,female'
        ]);
        $user = User::withTrashed()->findOrFail($id);
        $update = $user->update($request->all());
        if($update){
            $request->session()->flash('success', 'User was updated');
        }else{
            $request->session()->flash('error', 'User was not updated');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if(Auth::user()->id != $id){
            $delete = $user->delete();
            if($delete){
                session()->flash('success', 'User was deleted');
            }
        }else{
            session()->flash('error', 'Do not do it, do not delete yourself :)');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $restore = $user->restore();
        if($restore){
            session()->flash('success', 'User was restored');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm_profile_photo($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $update = $user->update(['profile_photo_verified' => true]);
        if($update){
            session()->flash('success', 'Confirmed');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_profile_photo($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $photo = $user->profile_photo;
        $update = $user->update(['profile_photo_verified' => false, 'profile_photo' => '']);
        if($update){
            if($photo) {
                delete_image('s3', 'profile-photos/original/'.$photo);
                delete_image('s3', 'profile-photos/thumbnail/'.$photo);
            }
            session()->flash('success', 'Profile photo was deleted');
        }
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_profile_photo(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $request->validate([
            'profile_photo' => 'required|image|max:2048|mimes:jpg,jpeg,png'.
                '|dimensions:min_width=25,min_height=25'
        ]);
        $filename = upload_profile_photo($request->file('profile_photo'), $user);
        if($filename){
            $user->update([
                'profile_photo' => $filename, 'profile_photo_verified' => false
            ]);
            $request->session()->flash('success', 'Profile photo was updated');
        }else{
            $request->session()->flash('error', 'Profile photo was not updated');
        }
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_password(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $request->validate([
            'password' => 'required|string|max:15|min:8|confirmed',
            'password_confirmation' => 'required|string'
        ]);
        $user->update(['password' => bcrypt($request->password)]);
        $request->session()->flash('success', 'Password was updated!');
        return back();
    }
}
