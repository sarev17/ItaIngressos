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
        #time{
            /* display: flex; */
            align-items: center;
            justify-content: center;
        }
        #time svg{
            margin-left: 15px;
            font-size: 14pt;
        }
        #timer{
            visibility: hidden;
        }
        #copy:hover{
            /* background-color: #1d459f; */
        }
    </style>
    <div>
        <h3 class="flex-m center">Confirme os dados do evento e pagamento</h3>
        <section class=" pad-panel flex-m center">
            <br><br>
            <section>
                <div class="flex-m center">
                    <div id="qrcode">
                        <center>
                            <section><span><b>{{ $event->name }}</b></span>
                                <span>Local: {{ $event->location }} {{ $event->city }}-{{ $event->uf }}</span>
                                <span>Data: {{ strftime('%d/%m/%Y', strtotime($event->day)) }} as {{ $event->start }}</span>
                                <span>Comprador: {{ $ticket->customer_name }} ({{ $ticket->customer_email }})</span>
                                <span></span>
                            </section>
                            <span>
                                Ingresso: R$ {{ number_format(($event->value_ticket), 2, ',', '.') }} + R$
                                {{ number_format(($commissions), 2, ',', '.') }} de taxa de serviço
                            </span>
                            <br>
                            <div>
                                <div id="time">
                                    <h4>Aguardando Pagamento.</h4>
                                    <span>Não reinicie essa página.<br>Verifique seu e-mail após realizar a transferência.</span>
                                    <i class="fa-spin fa-solid fa-spinner"></i>
                                    <span id="timer"></span>
                                </div>
                                @php echo $qrcode @endphp
                                <br>
                                <button id="copy" onclick="copyCode('TEST')" class="btn btn-primary">Copiar código PIX</button><br><br>
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
                            // console.log("{{$ticket->invoice_id}}");
                            if(response == 1){
                                window.location.href = '/confirm-pay';
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
            var duration = 5; // Converter para segundos
            display = document.querySelector('#timer'); // selecionando o timer
            startTimer(duration, display); // iniciando o timer
        };
    </script>
    <script>
        function copyCode(){
         text = '{{$ticket->qrcode}}'
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            var result = document.execCommand('copy');
            document.body.removeChild(input);
            $('#copy').text('Código PIX Copiado!');
            $('#copy').css('background-color','green')
            setInterval(function() {
                $('#copy').text('Copiar código PIX');
                $('#copy').css('background-color','#0B5ED7')
            }, 3000);

    }
    </script>
@endsection
