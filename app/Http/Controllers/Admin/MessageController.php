<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function show(Message $message)
    {
        return response()->json([
            'message' => $message,
        ]);
    }

    public function markAsRead(Message $message)
    {
        $message->update([
            'is_read' => true,
        ]);

        return response()->json([
            'message' => 'Message marked as read.',
            'data' => $message,
        ]);
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully.',
        ]);
    }
}
