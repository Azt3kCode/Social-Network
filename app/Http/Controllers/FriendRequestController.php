<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Chat;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function index()
    {
        $friends = FriendRequest::select(['id', 'recipient_id', 'sender_id', 'state'])
        ->whereIn('recipient_id', [Auth::user()->id])
        ->where('state', '=', 1)
        ->orWhereIn('sender_id', [Auth::user()->id])
        ->where('state', '=', 1)
        ->paginate();

        $arr = [];
        $users_id = [];
        $date = Carbon::now();

        foreach ($friends as $friend)
        {
            array_push($arr, $friend->id);

            if ($friend->sender_id != Auth::user()->id) {
                array_push($users_id, $friend->sender_id);
            } else {
                array_push($users_id, $friend->recipient_id);
            }
        }

        $users =  User::select(['id', 'name', 'image', 'color'])
        ->whereIn('id', $users_id)
        ->paginate();

        $messages = Chat::select(['id', 'friendRequest_id', 'user_id', 'message', 'created_at'])
        ->whereIn('friendRequest_id', $arr)
        ->oldest()
        ->paginate(15 * sizeof($arr));

        return view('chat.index', compact('friends', 'users', 'messages', 'date'));
    }

    public function show($id) 
    {
        $friend = FriendRequest::find($id);

        $date = Carbon::now();

        $friend_id = 0;
        if ($friend->sender_id != Auth::user()->id) {
            $friend_id = $friend->sender_id;
        } else {
            $friend_id = $friend->recipient_id;
        }

        $user = User::select(['id', 'name', 'image', 'color'])
        ->whereIn('id', [$friend_id])
        ->paginate();

        $chats = Chat::select(['id', 'friendRequest_id', 'user_id', 'message', 'created_at'])
        ->where('friendRequest_id', '=', $friend->id)
        ->paginate();

        return view('chat.show', compact('friend', 'user', 'chats', 'date'));
    }
}
