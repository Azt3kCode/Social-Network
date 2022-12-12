<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\FriendRequest;

use Illuminate\Support\Facades\Auth;
class ControlController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $arr = [];

        $users = User::select(['id', 'name', 'image', 'color'])->paginate();

        $requests = FriendRequest::select(['id', 'recipient_id', 'sender_id', 'state'])
        ->where('recipient_id', '=', Auth::user()->id)
        ->where('state', '=', 0)
        ->paginate();
        if ($requests->first() != null) {
            foreach ($requests as $request)
            {
                array_push($arr, $request->sender_id);
            }
        }
        $requestsFromYou = FriendRequest::select(['id', 'recipient_id', 'sender_id', 'state'])
        ->where('sender_id', '=', Auth::user()->id)
        ->where('state', '=', 0)
        ->paginate();

        if ($requestsFromYou->first() != null) {
            foreach ($requestsFromYou as $requestF)
            {
                array_push($arr, $requestF->recipient_id);
            }
        }

        
        $friends = FriendRequest::select(['id', 'recipient_id', 'sender_id', 'state'])
        ->whereIn('recipient_id', [Auth::user()->id])
        ->where('state', '=', 1)
        ->orWhereIn('sender_id', [Auth::user()->id])
        ->where('state', '=', 1)
        ->paginate();
        if ($friends->first() != null) {
            foreach ($friends as $friend)
            {
                if ($friend->sender_id != Auth::user()->id) {
                    array_push($arr, $friend->sender_id);
                } else {
                    array_push($arr, $friend->recipient_id);
                }
            }
        }

        $noFriends = User::select(['id', 'name', 'image', 'color'])
        ->where('id', '!=', Auth::user()->id)
        ->whereNotIn('id', $arr)
        ->paginate();

    return view('control', compact('users', 'noFriends', 'requests', 'requestsFromYou', 'friends'));
    }

    public function store($id)
    {
        $verifySender = FriendRequest::select(['id'])
        ->where('sender_id', '=', Auth::user()->id)
        ->where('recipient_id', '=', $id)
        ->paginate();

        if ($verifySender->first() != null) {
            return redirect()->route('control');
        }

        $verifyRecipient = FriendRequest::select(['id'])
        ->where('sender_id', '=', $id)
        ->where('recipient_id', '=', Auth::user()->id)
        ->paginate();

        if ($verifyRecipient->first() != null) {
            return redirect()->route('control');
        }

        $request = new FriendRequest;
        $request->sender_id = Auth::user()->id;
        $request->recipient_id = $id;
        $request->save();

        return redirect()->route('control');
    }

    function update($id)
    {
        $request = FriendRequest::find($id);
        $request->state = 1;
        $request->save();

        return redirect()->route('control');
    }

    function destroy($id)
    {
        $request = FriendRequest::find($id);
        $request->delete();

        return redirect()->route('control');
    }
}
