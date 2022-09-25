@php
    use Illuminate\Support\Facades\Storage;
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
@endphp
@extends('layouts.app')
@section('content')
    <style>
        .message{
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 30px;
        }
    </style>
    <div>
        <header class="flex-m center"><h1>Eventos Disponíveis</h1></header>
        <br>
        {{-- @include('ajax.searchbar.events-search') --}}
        <br>
        <section class="panel-cards flex">
            @if($events->count())
            @foreach ($events as $event )
                <div class="event-card">
                    <img src="{{$event->poster}}" alt="">
                    <br>
                    <h5>{{$event->name}}</h5>
                    <span>{{$event->city}} - {{$event->uf}}</span>
                    <span>Local: {{$event->location}}</span>
                    <span>Entrada: R$ {{number_format($event->value_ticket,2,',','.')}}</span>
                    <span><b>{{strftime('%d de %B',strtotime($event->day))}} as  {{$event->start}}</b></span>
                    <a class="btn btn-primary" href="{{route('event-detail',['id'=>$event->id])}}">Comprar ingresso</a>
                </div>
            @endforeach
            @else
                <div class="message"><h5>Não há eventos disponíveis</h5></div>
            @endif
        </section>
    </div>
@endsection
