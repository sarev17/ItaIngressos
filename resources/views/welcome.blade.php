@php
    use Illuminate\Support\Facades\Storage;
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
@endphp
@extends('layouts.home')
@section('content')
    <style>

        .message {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 30px;
        }

        .panel-cards {
            display: flex;
            flex-wrap: wrap;
        }

        /* .panel-cards img:hover{
                        height: 14.3rem;
                        width: 12.3rem;

                    } */
        .event {
            position: relative;
        }

        .event h5 {
            position: absolute;
            top: 37%;
            left: 11px;
            color: white;
        }

        .date {
            position: absolute;
            z-index: 1;
            bottom: 9px;
            /* width: 100%; */
            left: 6px;
            color: white;
            /* border: solid 1px; */
            padding: 1px 12px;
            border-radius: 0 12px;
            border: solid 1px;
        }

        .value {
            position: absolute;
            left: 14px;
            top: 11px;
            color: white;
            background-color: #066a06;
            padding: 2px 9px;
        }

        .location {
            position: absolute;
            z-index: 1;
            color: white;
            left: 13px;
            top: 59%;
        }

        @media(max-width:420px) {
            .event-card img{
                filter: brightness(0.3) !important;
                object-fit: cover !important;
                transform: scale(1.03) !important;
                transition-duration: 0.5s !important;
            }
            .data-card{
                opacity: 1 !important;
            }
            span{
                display: block;
            }

            .search-bar input{
                width: 80%;
            }
            .event-card img {
                width: 10rem;
            }

            .event-card {
                max-width: 158px;
            }

            .event-card a {
                width: 100%;
            }

        }

        .data-card {
            opacity: 0;
        }
        .event-card:hover .data-card{
            opacity: 1;
            transition-duration: 0.5s;
        }
        .event-card:hover img{
            filter: brightness(0.3);
            object-fit: cover;
            transform: scale(1.03);
            transition-duration: 0.5s;
        }

        .content header{
            margin-top: 5rem;
        }
    </style>
    <div class="content">
        {{-- <center>@include('ajax.searchbar.events-search')</center> --}}
        <header class="flex-m center section-title"><span>Eventos Disponíveis</span></header>
        <br>
        <section class="panel-cards">
            @if ($events->count())
                @foreach ($events as $event)
                    <div class="event-card">
                        <a href="{{ route('event-detail', ['id' => $event->id]) }}">
                            <div class="event">
                                <img src="{{ $event->poster }}" alt="">
                                <div class="data-card">
                                    <h5>{{ $event->name }}</h5>
                                    <span class="location"><i class="fa-solid fa-map-location-dot"></i> {{ $event->city }} -
                                        {{ $event->uf }}</span>
                                    <span class="value"> <i class="fa-solid fa-cart-shopping"></i> R$
                                        {{ number_format($event->value_ticket, 2, ',', '.') }}</span>
                                    <span class="date"><i class="fa-solid fa-calendar"></i>
                                        {{ strftime('%d/%m/%Y', strtotime($event->day)) }} <i class="fa-solid fa-clock"></i>{{$event->start}}</span>
                                </div>
                            </div>
                        </a>

                        {{-- <a class="btn btn-primary" href="{{route('event-detail',['id'=>$event->id])}}">Comprar</a> --}}
                        {{-- <br> --}}
                        {{-- <span>Local: {{$event->location}}</span> --}}
                    </div>
                @endforeach
            @else
                <div class="message">
                    <h5>Não há eventos disponíveis</h5>
                </div>
            @endif
        </section>
    </div>
@endsection
