@extends('layouts.app')
@section('content')
<style>
    .bg-green{
        background-color: #78cb78;
    }
    .bg-blue{
        background-color: #bbc0ff;
    }
    td a{
        width: 5rem;
    }
</style>
    <div class="panel-content">
        <section>
            <div class="container">
                <section class="btn-event" style="text-align: end;">
                    <nav class="action-events">
                        <a class="btn btn-primary btn-sm" href="{{ route('event.create') }}">
                            <i class="fa-solid fa-calendar-plus"></i>
                            <span style="font-size: 10pt">Cadastrar Evento</span>
                        </a>
                    </nav>
                </section>
                <br>
                {{-- <section class="data-panel">
                    <div class="cards">
                        <div class="card bg-green">
                            <section class="">
                               <div>
                                   <span class="big">Vendas</span>
                                    <span class="info"><b>R$ 1.542,50</b></span>
                               </div>
                               <div>
                                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                               </div>
                            </section>
                            <footer>
                                <span>REF: 01/08 á 10/08 de 2022</span>
                            </footer>
                        </div>
                        <div class="card bg-blue">
                            <section class="">
                               <div>
                                   <span class="big">Recebido</span>
                                    <span class="info">R$ 875,00</span>
                                    <br>
                                    <span>A enviar: <b>R$ 356,00</b></span>
                               </div>
                               <div>
                                <i class="fa-sharp fa-solid fa-building-columns"></i>
                               </div>
                            </section>
                            <footer>
                                <a href="">Histórico</a>
                            </footer>
                        </div>
                        <div class="card">
                            <section class="">
                               <div>
                                    <span class="big">Eventos</span>
                                    <br>
                                    <span><b>Disponíveis: </b>2</span>
                                    <span><b>Vendas: </b>120</span>
                               </div>
                               <div>
                                <i class="fa-solid fa-user-group"></i>
                               </div>
                            </section>
                            <footer>
                                <span>REF: 01/08 á 10/08 de 2022</span>
                            </footer>
                        </div>
                        <div class="card">
                            <section class="">
                               <div>
                                    <span class="big">Meus Dados</span>
                                    <br>
                                    <span>Nome: <b>Andre Veras</b></span>
                                    <span>Chave PIX: <b>88981700168</b></span>
                               </div>
                            </section>
                            <footer>
                                <a href="">Editar</a>
                            </footer>
                        </div>
                    </div>
                </section> --}}
                <br><br>
                <center>
                    <h3>Dados dos seus eventos</h3>
                </center>
                <section class="table-events">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nome do evento</th>
                                <th scope="col">Ingressos vendidos</th>
                                <th scope="col">Preço atual</th>
                                <th scope="col">Total apurado</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <th scope="row">{{ $event->name }}</th>
                                    <td>{{ $event->tickets->where('paid', 1)->count() }}</td>
                                    <td>R$ {{ number_format($event->value_ticket, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($event->tickets->where('paid', 1)->sum('price'), 2, ',', '.') }}
                                    </td>
                                    {{-- <td><a href="" class="btn btn-sm btn-primary">Ver detalhes</a></td> --}}
                                    <td><a href="/checkin?event={{$event->id}}" class="btn btn-sm btn-primary"><i class="fa-sharp fa-solid fa-qrcode"></i> Validar ingressos</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </section>


    </div>
@endsection
