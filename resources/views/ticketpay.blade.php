@php
    use Illuminate\Support\Facades\Storage;
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    use BaconQrCode\Encoder\QrCode;
@endphp
@extends('layouts.app')
@section('content')
<style>
    span{
        display: block;
    }
    .flex-m{
        display: flex;
    }
    #poster{
        width: 21rem;
        height: 28rem;
        margin: 0 30px;
    }
    #pix{
        width: 18rem;
    }
    .detail-pix{
        background-color: #1d459f;
        justify-content: space-between;
        padding: 5px 13px;
        align-items: center;
        font-size: 15pt;
        font-weight: 900;
        color: white;
        border-radius: 10px;
        margin: 0 20px;
    }
    #data-payer input{
        display: block;
        width: 100%;
        margin: -4px 0 15px 0;
        border: solid 1px;
        border-radius: 7px;
        font-size: 13pt;
        height: 30px;
    }
</style>
    <div>
        <section class=" pad-panel flex-m center">
                <figure>
                    <img id="poster" src="/{{$event->poster}}" alt="">
                </figure>
                <section style="text-align: center">
                    <h4>{{$event->name}}</h4>
                        <span>Local: {{$event->location}} {{$event->city}}-{{$event->uf}}</span>
                        <span>Data: {{strftime('%d de %B',strtotime($event->day))}} as  {{$event->start}}</span>
                        <span>Valor: R$ {{number_format($event->value_ticket,2,',','.').' + R$ '.
                            number_format($commissions,2,',','.'). ' de taxa de serviço'}}
                        </span>
                    <form id="data-payer" action="{{route('tickets.store')}}" method="post">
                        @csrf
                        <br>
                        <h5>Dados para gerar o Ingresso</h5>
                        <input type="hidden" value="{{$event->id}}" name="event_id">
                        <input required type="text" name="customer_name" placeholder="Nome">
                        <input required type="email" name="customer_email" placeholder="Email">
                        <input required minlength="14" onblur="validateCPFBlur(this.value)" class="cpf" type="text" name="customer_cpf" placeholder="CPF">
                        <input required minlength="14" id="contact" type="text" name="customer_contact" placeholder="Celular">
                        <small>
                            <small style="color: rgb(196, 15, 15)">* </small>
                             Esses dados de contato receberão apenas notificações sobre o ingresso comprado.
                        </small>
                        <br><br>
                        <button class="btn btn-primary" type="submit">Gerar Ingresso</button>
                    </form>
                </section>
                <section style="text-align: center">
                </section>
        </section>
    </div>
@endsection
