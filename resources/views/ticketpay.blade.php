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
    }
</style>
    <div>
        <section class="flex-m center">
                <figure>
                    <img id="poster" src="/{{$event->poster}}" alt="">
                </figure>
                <section style="text-align: center">
                    <h4>{{$event->name}}</h4>
                    <span>Data: {{strftime('%d de %B',strtotime($event->day))}} as  {{$event->start}}</span>
                    <span>Valor: R$ {{number_format($event->value_ticket,2,',','.').' + R$ '.
                        number_format($commissions,2,',','.'). ' de taxa de serviço'}}
                    </span>
                    <div id="qrcode">@php echo $qrcode @endphp</div>
                    <div class="detail-pix flex">
                        <i class="fa-brands fa-pix"></i>
                        <span>R$ {{number_format($total,2,',','.')}}</span>
                    </div>
                </section>
        </section>
    </div>
@endsection
