<?php

namespace App\Http\Controllers;

use App\Mail\GetInTouchWithPostUser;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post_detail_contact(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer',
            'phone' => 'required|string',
            'message' => 'required'
        ]);

        $post = Post::whereNotNull('verified_at')->with('user')->findOrFail($request->post_id);
        if(!$post->user || !Auth::user()->email_verified_at) return response()->json([], 404);
        $data = [
            'message' => $request->message,
            'email' => Auth::user()->email,
            'phone' => $request->phone
        ];
        $send_mail = Mail::to($post->user->email)
            ->queue(new GetInTouchWithPostUser($data));
        return response()->json([], 200);
    }
}
