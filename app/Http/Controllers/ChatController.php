<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FriendRequest;
use App\Models\Chat;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function create(Request $request, $id)
    {
        $messages = Chat::where('friendRequest_id', $id);

        $chat = new Chat;
        $chat->friendRequest_id = $id;
        $chat->user_id = Auth::user()->id;
        $chat->message = $request->input('message');

        $chat->save();
  
        if ($messages->count() > 15) {
            $aux = $messages->first();
            $aux->delete();
        }

        return redirect()->route('chat.show', $id);
    }
}
