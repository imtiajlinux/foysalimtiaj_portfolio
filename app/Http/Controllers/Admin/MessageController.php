<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

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


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $message = Message::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully.',
        ], 201);
    }
}
