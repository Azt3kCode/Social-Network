@extends('layouts.app')

@section('content')

<style>
                    .card-header {
                        font-weight: 900;
                    }
                    .card__container {
                        width: 100%;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        height: 60px;
                        padding: 0 20px;
                        margin: 0 auto;
                        border-bottom: 1px solid #00000011;
                    }

                    .card__name {
                        font-size: 1rem;
                        font-weight: 400;
                        color: #333;
                        width: 100%;
                    }

                    .delete-btn {
                        width: auto;
                        height: auto;
                        color: #ff7777;
                        font-size: 0.9rem;
                        font-weight: 900;
                        border: none;
                        background: none;
                        border-radius: 5px;
                        transition: all 0.3s ease;
                    }

                    .delete-btn:hover {
                        background: #ff777733;
                    }

                    form {
                        width: auto;
                        height: auto;
                    }

                    .accept-btn {
                        width: auto;
                        height: auto;
                        color: #44aaff;
                        font-size: 0.9rem;
                        font-weight: 900;
                        border: none;
                        border-radius: 5px;
                        background: none;
                    }

                    
                    .accept-btn:hover {
                        background: #44aaff33;
                    }

                    .card__div {
                        width: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: right;
                    }
                    
                    .non {
                        color: #777;
                        width: 100%;
                        height: 75px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto;
                        font-size: 0.9rem;
                    }
                    
                    .default {
                        width: 100%;
                        opacity: 0.5;
                        font-size: 0.9rem;
                    }

                </style>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('👥 Amigos') }}</div>
                @foreach ($friends as $friend)
                    <article class="card__container">
                    @if ($users->find($friend->sender_id)->id != Auth::user()->id)
                        <div class="card__img__container" style='background: {{ $users->find($friend->sender_id)->color }}77'>
                            <img src="{{ $users->find($friend->sender_id)->image }}" class="card__img">
                        </div>
                        <strong class="card__name">
                            {{ $users->find($friend->sender_id)->name }}
                        </strong>
                    @else
                        <div class="card__img__container" style='background: {{ $users->find($friend->recipient_id)->color }}77'>
                            <img src="{{ $users->find($friend->recipient_id)->image }}" class="card__img">
                        </div>
                        <strong class="card__name">
                            {{ $users->find($friend->recipient_id)->name }}
                        </strong>
                    @endif
                        </strong>
                        <form action="{{ route('control.delete', $friend->id )}}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="submit" value="✘ Eliminar" class="delete-btn">
                        </form>
                    </article>
                @endforeach
                @if ($friends->first() == null)
                    <p class="non">No tienes amigos agregados de momento.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('📩 Solicitudes') }}</div>
                @foreach ($requests as $request)
                    <article class="card__container">
                        <div class="card__img__container" style='background: {{ $users->find($request->sender_id)->color }}77'>
                            <img src="{{ $users->find($request->sender_id)->image }}" class="card__img">
                        </div>
                        <strong class="card__name">
                            {{ $users->find($request->sender_id)->name }}
                        </strong>
                        <div class="card__div">
                        <form action="{{ route('control.update', $request->id)}}" method="POST">
                        <!--<form action="{{ route('control.update', $users->find($request->sender_id)->id)}}" method="POST">-->
                            @csrf
                            <input type="submit" value="✔ Aceptar" class="accept-btn">
                        </form>
                        <form action="{{ route('control.delete', $request->id )}}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="submit" value="✘ Rechazar" class="delete-btn">
                        </form>
                        </div>
                    </article>
                @endforeach
                @foreach ($requestsFromYou as $requestF)
                    <article class="card__container">
                        <div class="card__img__container" style='background: {{ $users->find($requestF->recipient_id)->color }}77'>
                            <img src="{{ $users->find($requestF->recipient_id)->image }}" class="card__img">
                        </div>
                        <strong class="card__name">
                            {{ $users->find($requestF->recipient_id)->name }}
                            <span class="default">⌛ En espera</span>
                        </strong>
                        <form action="{{ route('control.delete', $requestF->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="submit" value="✘ Cancelar" class="delete-btn">
                        </form>
                    </article>
                @endforeach
                @if ($requests->first() == null && $requestsFromYou->first() == null)
                    <p class="non">No tienes nuevas solicitudes.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('🌎 Más personas') }}</div>
                    @foreach ($noFriends as $noFriend)
                        <article class="card__container">
                            <div class="card__img__container" style='background: {{ $noFriend->color }}77'>
                                <img src="{{ $noFriend->image }}" class="card__img">
                            </div>
                            <strong class="card__name">
                                {{$noFriend->name}}
                            </strong>
                            <form action="{{ route('control.store', $noFriend->id) }}" method="POST">
                                @csrf
                                <input type="submit" value="+ Agregar" class="accept-btn">
                            </form>
                        </article>
                    @endforeach
                    @if ($noFriends->first() == null)
                    <p class="non">No hay más personas para agregar.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
