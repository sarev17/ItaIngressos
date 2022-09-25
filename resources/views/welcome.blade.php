@php
    use Illuminate\Support\Facades\Storage;
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
@endphp
@extends('layouts.app')
@section('content')

    <div>
        <header class="flex-m center"><h1>Eventos Disponíveis</h1></header>
        <br>
        <section class="panel-cards flex">
            @foreach ($events as $event )
                <div class="card">
                    <img src="{{$event->poster}}" alt="">
                    <br>
                    <h5>{{$event->name}}</h5>
                    <span>Entrada: R$ {{number_format($event->value_ticket,2,',','.')}}</span>
                    <span><b>{{strftime('%d de %B',strtotime($event->day))}} as  {{$event->start}}</b></span>
                    <a class="btn btn-primary" href="{{route('event-detail',['id'=>$event->id])}}">Comprar ingresso</a>
                </div>
            @endforeach
        </section>
    </div>
@endsection
