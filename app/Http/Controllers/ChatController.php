<?php

namespace App\Http\Controllers;

use App\Events\chatEvent;
use App\Events\deleteMessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = Chat::select('id', 'sender_id', 'receiver_id', 'updated_at')
            ->with(['sender', 'receiver','messages'])
            ->where('sender_id', Auth::user()->id)
            ->orWhere('receiver_id', Auth::user()->id)
            ->get();
        return view('chat', compact('chats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat = Chat::with(['sender', 'receiver','messages'])->find(decrypt($id));
        if($chat) {
            $recevicer_id = null;
            if($chat->sender_id == auth()->user()->id) {
                $recevicer_id = $chat->receiver_id; 
            } else {
                $recevicer_id = $chat->sender_id; 
            }
        }
        return view('message', compact('chat','recevicer_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }

    public function sendMessage(Request $request)
    {
        $data['chat_id'] = decrypt($request->chat_id);
        $data['send_by'] = auth()->user()->id;
        $data['message'] = $request->message;
        Message::create($data);
        // Broadcast the new message
        $chat = Chat::find(decrypt($request->chat_id));
        if($chat) {
            $recevicer_id = null;
            if($chat->sender_id == auth()->user()->id) {
                $recevicer_id = $chat->receiver_id; 
            } else {
                $recevicer_id = $chat->sender_id; 
            }
            broadcast(new chatEvent($recevicer_id, $chat->id))->toOthers();
        }
        return response()->json(['status' => 'Message sent successfully']);
    }

    public function receiveMessage(Request $request)
    {
        $chat = Chat::find($request->chat_id);
        if($chat) {
            $send_by = null;
            if($chat->sender_id == $request->receiver_id) {
                $send_by = $chat->receiver_id; 
            } else {
                $send_by = $chat->sender_id; 
            }
            $message = Message::where('chat_id', $chat->id)->where('send_by', $send_by)->latest('id')->first();

            if($message) {
                return response()->json(['message' => $message->message, 'status' => true]);
            }
            return response()->json(['message' => '', 'status' => false]);

        }
    }

    public function deleteMessage(Request $request) {
        $message = Message::where('id', $request->message)->delete();
        broadcast(new deleteMessage($request->message))->toOthers();
        return response()->json(['status' => true]);
    }

    public function getUsers(Request $request)
    {   
        $chats = Chat::where('receiver_id', auth()->user()->id)->orWhere('sender_id', auth()->user()->id)->get()->toArray();
        
        $senders = array_column($chats, 'sender_id');
        $recevicers = array_column($chats, 'receiver_id');
        $users_id = array_merge($senders, $recevicers);

        $users = User::select('id', 'name')
            ->where('name', 'LIKE', "%$request->search%")
            ->whereNotIn('id', $users_id)
            ->where('name', 'NOT LIKE', Auth::user()->name)->take(5)->get();
        return response()->json(['data' => $users, 'status' => true]);
    }

    public function createChat(Request $request)
    {
        if($request->has('user_id') && $request->user_id) {
           $data['receiver_id'] = $request->user_id; 
           $data['sender_id'] = auth()->user()->id; 
           $chat = Chat::where(function($query) use ($request) {
                return $query->where('receiver_id', $request->user_id)->where('sender_id', auth()->user()->id);
           })->orWhere(function($query) use ($request) {
            return $query->where('receiver_id', auth()->user()->id)->where('sender_id', $request->user_id);
            })->first();
            if(!$chat) {
                $chat = Chat::create($data);
            }
            $url  = route('show', encrypt($chat->id));
            return response()->json(['url' => $url, 'status' => true]);
        }
        return response()->json(['status' => false]);
    }


}
