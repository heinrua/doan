<?php
namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\NewMessageEvent;


class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('pages.chat', compact('messages'));
    }

    public function send(Request $request)
    {
        $msg = new Message();
        $msg->message = $request->message;

        if (auth()->check()) {
            $msg->sender_name = auth()->user()->full_name;
        } else {
            if (!session()->has('anonymous_name')) {
                $last = Message::where('sender_name', 'like', 'Người dân #%')->latest()->first();
                $num = $last ? (int) filter_var($last->sender_name, FILTER_SANITIZE_NUMBER_INT) : 0;
                session(['anonymous_name' => 'Người dân #' . ($num + 1)]);
            }
            $msg->sender_name = session('anonymous_name');
        }

        $msg->save();
        

// Tạm ẩn broadcast để test:
try {
   event(new NewMessageEvent($msg));

} catch (\Throwable $e) {
    \Log::error('❌ Broadcast lỗi:', [$e->getMessage()]);
}



        return response()->json(['sent' => true]);
    }
}
