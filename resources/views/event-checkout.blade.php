@php
use Illuminate\Support\Facades\Storage;
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
use BaconQrCode\Encoder\QrCode;
@endphp
@extends('layouts.app')
@section('content')
    <style>
        #event-detail {
            /* display: flex; */
            align-items: center;
        }

        #event-detail span {
            display: block;
            text-align: center;
        }

        #qrcode span {
            display: block;
        }

        #pix {
            width: 18rem;
        }

        .detail-pix {
            background-color: #1d459f;
            justify-content: space-between;
            padding: 5px 13px;
            align-items: center;
            font-size: 15pt;
            font-weight: 900;
            color: white;
            border-radius: 10px;
            width: 50%;
        }

        span {
            font-size: 12pt;
        }
    </style>
    <div>
        <h3 class="flex-m center">Confirme os dados do evento e pagamento</h3>
        <br>
        <section class=" pad-panel flex-m center">
            <br><br>
            <section>
                <div class="flex-m center">
                    <div id="qrcode">
                        <center>
                            <section><span><b>{{ $event->name }}</b></span>
                                <span>Local: {{ $event->location }} {{ $event->city }}-{{ $event->uf }}</span>
                                <span>Data: {{ strftime('%d de %B', strtotime($event->day)) }} as {{ $event->start }}</span>
                                <span>Comprador: {{ $ticket->customer_name }} ({{ $ticket->customer_email }})</span>
                                <span></span>
                            </section>
                            <span>
                                Ingresso: R$ {{ number_format($event->value_ticket, 2, ',', '.') }}
                                + R$ {{ number_format($commissions, 2, ',', '.') }} de taxa de serviço
                            </span>
                            <br>
                            <div>
                                <div>
                                    <h4>Aguardando Pagamento: </h4>
                                    <span id="timer"></span>
                                </div>
                                @php echo $qrcode @endphp
                            </div>
                        </center>
                    </div>
                </div>
            </section>
        </section>
        <center>
            <div class="detail-pix flex">
                <i class="fa-brands fa-pix"></i>
                <span>TOTAL : R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
        </center>
    </div>
    <script>
        function startTimer(duration, display) {
            var timer = duration,
                minutes, seconds;
            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.textContent = minutes + ":" + seconds;
                if (--timer < 0) {
                    timer = duration;
                    $.ajax({
                        method: 'GET',
                        url: "/verify-payment/{{$ticket->invoice_id}}",
                        success: function(response) {
                            if(response == 1){
                                window.location.href = '/confirm-pay'
                            }
                        },
                        error: function(response) {
                            console.log("error", response);
                        }
                    });
                }
            }, 1000);
        }
        window.onload = function() {
            var duration = 15; // Converter para segundos
            display = document.querySelector('#timer'); // selecionando o timer
            startTimer(duration, display); // iniciando o timer
        };
    </script>
@endsection
