@extends('layouts.app')
@section('content')
    <div class="panel-content">
        
        <section>
        <div class="container">
            <section class="btn-event" style="text-align: end;">
                <nav class="action-events">
                    <a class="btn btn-primary" href="{{route('event.create')}}">
                        <i class="fa-solid fa-calendar-plus"></i>
                        <span>Cadastrar Evento</span>
                    </a>
                </nav>
            </section>
            <br><br>



            <center><h3>Dados dos seus eventos</h3></center>
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Nome do evento</th>
                <th scope="col">Ingressos vendidos</th>
                <th scope="col">Preço atual</th>
                <th scope="col">Total apurado</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                    <th scope="row">{{$event->name}}</th>
                    <td>{{$event->tickets->where('paid', 1)->count()}}</td>
                    <td>R$ {{number_format($event->value_ticket, 2, ',', '.')}}</td>
                    <td>R$ {{number_format($event->tickets->where('paid', 1)->sum('price'), 2, ',', '.')}}</td>
                    <td><a href="" class="btn btn-sm btn-primary">Ver detalhes</a></td>
                </tr>                    
                @endforeach
            </tbody>
            </table>
            </div>
        </section>


    </div>
@endsection
