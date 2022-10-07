@extends('layouts.app')
@section('content')
<style>
    .customer-info span{
        display: block;
    }
    .customer-info{
        margin: 20px 0;
        font-size: 12pt;
    }
    .card-info h3{
        color: green !important;
    }
    .card-info h5{
        background-color: forestgreen;
        padding: 0.7rem;
        width: fit-content;
        color: white;
        border-radius: 9px;
    }
</style>
    <div>
        <section class="panel-content">
            @if($message == 'valid')
                <center>
                    <div class="card-info">
                        <h3>Ingresso válido <i class="fa-solid fa-circle-check"></i></h3>
                        <div class="customer-info">
                            <span>Cliente: {{$ticket->customer_name}} - {{$ticket->customer_cpf}}</span>
                            <br><picture><img  src="/{{$ticket->event->poster}}" alt=""></picture>
                            <br><br><h5>Entrada Confirmada!</h5>
                        </div>
                        <br>
                    </div>
                </center>
            @endif
        </section>
    </div>
@endsection
