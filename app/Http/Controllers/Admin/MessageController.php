<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', [
            'messages' => Message::latest()->paginate(20),
        ]);
    }

    public function read(Message $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Ditandai sudah dibaca');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success', 'Pesan dihapus');
    }
}
