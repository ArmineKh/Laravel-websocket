<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        $messages = MessageResource::collection($messages)->resolve();

        return inertia('Message/index', compact('messages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => 'required|string',
        ]);
//        $data = $request->validated();
        $message = Message::create($data);

        broadcast(new StoreMessageEvent($message))->toOthers();

        return MessageResource::make($message)->resolve();

    }

}
