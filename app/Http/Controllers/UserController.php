<?php

namespace App\Http\Controllers;

use App\Events\SendLikeEvent;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return inertia('User/Show', compact('user'));
    }

    public function sendLike(User $user, Request $request)
    {
        $data = $request->validate([
            'from_id' => 'required|integer',
        ]);

        $likeStr = 'Your like from user with id ' . $data['from_id'];

        broadcast(new SendLikeEvent($likeStr, $user->id))->toOthers();

        return response()->json([
            'like_str' => $likeStr
        ], 200);
    }
}
