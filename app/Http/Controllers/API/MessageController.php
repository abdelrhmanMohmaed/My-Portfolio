<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('id', 'DESC')->get();

        return response()->json([
            'messages' => $messages
        ], 200);
    }
    public function toggleStatus(Message $message)
    {
        $message->status = !$message->status;
        $message->save();
    }

    public function delete(Message $message)
    {
        return $message->delete();
    }
}
