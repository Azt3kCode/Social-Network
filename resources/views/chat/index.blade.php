@extends('layouts.app')

@section('content')
    <style>
        .chats {
            width: 100%;
            height: auto;
        }

        .chat__card {
            position: relative;
            width: 100%;
            height: 75px;
            border-bottom: 1px solid #00000011;
            display: flex;
            align-items: center;
            justify-content: left;
            padding: 0 20px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .card__img {
            width: 85%;
            height: 85%;
            border-radius: 50%;
        }

        .card__info {
            display: flex;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        .card__info > strong {
            color: #444;
        }
        
        .card__info > p {
            margin: 0;
            color: #00000077;
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

        .card__time {
            font-size: 0.70rem;
            color: #00000077;
            height: 100%;
            padding: 20px 0;
            width: 150px;
            text-align: right;
        }

        .card__link {
            color: #000;
            width: 100%;
            height: 100%;
            text-decoration: none;
        }

        .card__link:hover  > .chat__card{
            color: #000;
            filter: brightness(0.95);
        }
    </style>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('👥 Amigos') }}</div>
    @foreach ($friends as $friend)
        <a class="card__link" href="{{ route('chat.show', $friend->id) }}">
        <section class="chat__card">
        @if ($friend->sender_id != Auth::user()->id)
            <div class="card__img__container" style='background: {{ $users->find($friend->sender_id)->color }}77'>
                <img src="{{ $users->find($friend->sender_id)->image }}" class="card__img">
            </div>
            <div class="card__info">
                <strong>{{ $users->find($friend->sender_id)->name }}</strong>
                @if ($messages->where('friendRequest_id', $friend->id)->last() == null)
                    <p>Se el primero en mandar un mensaje!</p>
                @else<p>
                    @if ($messages->where('friendRequest_id', $friend->id)->last()->user_id == Auth::user()->id)
                        Tú:
                    @endif
                    {{ $messages->where('friendRequest_id', $friend->id)->last()->message  }}</p>
                @endif
            </div>
            @if ($messages->where('friendRequest_id', $friend->id)->last() != null)
            <span class="card__time">
                @if ($date->diffInMinutes($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 60)
                    Hace
                    {{ $date->diffInMinutes($messages->where('friendRequest_id', $friend->id)->last()->created_at)  }}
                    @if ($date->diffInMinutes($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 2)
                        minuto
                    @else
                        minutos
                    @endif
                @elseif($date->diffInHours($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 24)
                    Hace
                    {{ $date->diffInHours($messages->where('friendRequest_id', $friend->id)->last()->created_at) }}
                    @if ($date->diffInHours($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 2)
                        hora
                    @else
                        horas
                    @endif
                @endif
            </span>
            @endif
        @else
            <div class="card__img__container" style='background: {{ $users->find($friend->recipient_id)->color }}77'>
                <img src="{{ $users->find($friend->recipient_id)->image }}" class="card__img">
            </div>
            <div class="card__info">
                <strong>{{ $users->find($friend->recipient_id)->name }}</strong>
                @if ($messages->where('friendRequest_id', $friend->id)->last() == null)
                    <p>Se el primero en mandar un mensaje!</p>
                @else
                    <p>
                    @if ($messages->where('friendRequest_id', $friend->id)->last()->user_id == Auth::user()->id)
                        Tú:
                    @endif
                    {{ $messages->where('friendRequest_id', $friend->id)->last()->message  }}</p>
                @endif
            </div>
            @if ($messages->where('friendRequest_id', $friend->id)->last() != null)
            <span class="card__time">
                @if ($date->diffInMinutes($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 60)
                    Hace
                    {{ $date->diffInMinutes($messages->where('friendRequest_id', $friend->id)->last()->created_at)  }}
                    @if ($date->diffInMinutes($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 2)
                        minuto
                    @else
                        minutos
                    @endif
                @elseif($date->diffInHours($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 24)
                    Hace
                    {{ $date->diffInHours($messages->where('friendRequest_id', $friend->id)->last()->created_at) }}
                    @if ($date->diffInHours($messages->where('friendRequest_id', $friend->id)->last()->created_at) < 2)
                        hora
                    @else
                        horas
                    @endif
                @endif
            </span>
            @endif
        @endif
        </section>
        </a>
    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection