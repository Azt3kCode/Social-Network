@extends('layouts.app')

@section('content')
<style>
   .navbar {
      display: none;
   }

   .friend{
      position: absolute;
      bottom: 15px;
      top: 15px;
      right: 0;
      left: 0;
   }

   .friend > .row {
      height: 100%;
   }

   .friend > .col-md-12 {
      height: 100%;
   }

   .card-header {
      position: relative;
      font-weight: 900;
      display: flex;
      align-items: center;
      z-index: 1;

   }

   .card {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
   }

   .card__img {
            width: 85%;
            height: 85%;
            border-radius: 50%;
   }
        
   .card__img__container{
      width: 50px;
      min-width: 50px;
      height: 50px;
      min-width: 50px;
      border-radius: 25px;
      margin-right: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .inputs {
      width: 100%;
      height: 60px;
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: space-around;
      bottom: 0;
      overflow: hidden;
      box-shadow: 0 -10px 20px #00000007;
      z-index: 1;
   }

   .input__text {
      width: 85%;
      height: 40px;
      margin: 0;
      padding: 0 20px;
      border: none;
      border-radius: 20px;
      outline: none;
      color: #000;
   }

   .input__text::placeholder {
      color: #000000aa;
   }
 
   .input__submit {
      width: 40px;
      height: 40px;
      border-radius: 20px;
      margin: 0;
      padding: 0;
      border: none;
      background: #0099ff;
      font-size: 1.5rem;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .card-msg {
      position: absolute;
      width: 100%;
      height: auto;
      top: 67px;
      bottom: 60px;
      overflow: scroll;
      overflow-x: hidden;
      scroll-behavior: smooth;
      scroll-snap-align: end;
      margin: 0;
   }

   .card-msg::-webkit-scrollbar {
      width: 10px;
   }

   .card-msg::-webkit-scrollbar-track {
      background: transparent;
   }

   .card-msg::-webkit-scrollbar-thumb {
      background: #00000022;
      border-radius: 5px;
   }

   .card-return {
      font-size: 2rem;
      text-decoration: none;
      margin-right: 10px;
      width: 40px;
      height: 40px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .card-return:hover {
      background: #00000011;
   }

   .message-card {
      position: relative;
      height: auto;
      padding: 10px 15px 2px 15px;
      background: #0099ff77;
      margin: 2px 0;
      border-radius: 0 10px 10px 0;
      overflow-wrap: break-word;
      width: auto;
      max-width: 60%;
   }

   .message-card_div {
      display: flex;
      align-items: center;
      justify-content: left;
   }

   .mine_div {
      display: flex;
      align-items: center;
      justify-content: right;
   }

   .mine {
      position: relative;
      height: auto;
      padding: 10px 15px 2px 15px;
      background: #0099ff77;
      margin: 1px 0;
      border-radius: 10px 0px 0px 10px;
      overflow-wrap: break-word;
      width: auto;
      max-width: 60%;
      text-align: right;
   }

   .message-card > span:first-child, .mine > span:first-child {
      max-width: 60%;
      color: #000;
      font-size: 0.9rem;
   }

   .message-card > span:last-child,.mine > span:last-child {
      color: #000000aa;
      font-size: 0.75rem;
      display: flex;
      align-items: bottom;
      justify-content: right;
   }
</style>
<div class="container friend">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <a href="{{ route('chat') }}" style="color: {{ $user->first()->color }}77" class="card-return">🡐</a>
                  <div class="card__img__container" style='background: {{ $user->first()->color }}77'>
                     <img src="{{ $user->first()->image }}" class="card__img">
                  </div>
                  {{$user->first()->name}}
               </div>
               <div id="card-msg" class="card-msg" style="background: {{ $user->first()->color }}04">
                  @foreach ($chats as $chat)
                     <div class="@if ($chat->user_id == Auth::user()->id) mine_div @else message-card_div @endif">
                     <label 
                     style="background: 
                     @if ($chat->user_id == Auth::user()->id) 
                        {{$user->first()->color}}77
                     @else
                        {{$user->first()->color}}11
                     @endif"
                     class="@if ($chat->user_id == Auth::user()->id) mine @else message-card @endif">
                        <span>{{$chat->message}}</span>
                        <span>
                           @if ($date->diffInMinutes($chat->created_at) < 60)
                              Hace
                              {{ $date->diffInMinutes($chat->created_at) }}
                              @if ($date->diffInMinutes($chat->created_at) < 2)
                                    minuto
                              @else
                                    minutos
                              @endif
                           @elseif($date->diffInHours($chat->created_at) < 24)
                              Hace
                              {{ $date->diffInHours($chat->created_at) }}
                              @if ($date->diffInHours($chat->created_at) < 2)
                                    hora
                              @else
                                    horas
                              @endif
                           @endif
                        </span>
                     </label>
                     </div>
                  @endforeach
               </div>
               <form action="{{ route('chat.create', $friend->id) }}" method="POST" class="inputs" style="background: {{ $user->first()->color }}22">
                  @csrf
                  <input class="input__text" type="text" name="message" placeholder="Escribe un mensaje" style="background: {{ $user->first()->color }}22">
                  <input class="input__submit" type="submit" value="➤" style="background: {{ $user->first()->color }}bb"> 
               </form>
            </div>
        </div>
    </div>
</div>
<script>
   document.getElementById('card-msg').scrollTop = document.getElementById('card-msg').scrollHeight;
</script>
@endsection