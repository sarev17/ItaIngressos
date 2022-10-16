@php
use Illuminate\Support\Facades\Storage;
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
use BaconQrCode\Encoder\QrCode;
@endphp
@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <style>
        span {
            display: block;
        }

        .flex-m {
            display: flex;
        }

        #poster {
            width: 21rem;
            height: 28rem;
            margin: 0 30px;
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
            margin: 0 20px;
        }

        #data-payer input {
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
                <img id="poster" src="/{{ $event->poster }}" alt="">
            </figure>
            <section style="text-align: center">
                <h4>{{ $event->name }}</h4>
                <span>Local: {{ $event->location }} {{ $event->city }}-{{ $event->uf }}</span>
                <span>Data: {{ strftime('%d de %B', strtotime($event->day)) }} as {{ $event->start }}</span>
                <span>Valor: R$
                    {{ number_format($event->value_ticket, 2, ',', '.') .
                        ' + R$ ' .
                        number_format($commissions, 2, ',', '.') .
                        ' de taxa de serviço' }}
                </span>
                <form id="data-payer" action="{{ route('tickets.store') }}" method="post">
                    @csrf
                    <br>
                    <h5>Dados para gerar o Ingresso</h5>
                    <input type="hidden" value="{{ $event->id }}" name="event_id">
                    <input required type="text" name="customer_name" placeholder="Nome">
                    <input required type="email" name="customer_email" placeholder="Email" id="email">
                    <input required minlength="14" onblur="validateCPFBlur(this.value)" class="cpf" type="text"
                        name="customer_cpf" placeholder="CPF">
                    <input required minlength="14" id="contact" type="text" name="customer_contact"
                        placeholder="Celular">
                    <small>
                        <small style="color: rgb(196, 15, 15)">* </small>
                        Esses dados de contato receberão apenas notificações sobre o ingresso comprado.
                    </small>
                    <br><br>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                        id="btn-ticket">
                        Gerar Ingresso
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmação de e-mail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Enviamos um código de confirmação para o e-mail <b><span id="send-email"></span></b> digite-o
                                        abaixo:</p>
                                    <input type="number" maxlength="4" minlength="4" type="text" placeholder="CODIGO"
                                        id="code">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    {{-- <button type="button" class="btn btn-primary" id="btn-code">Confirmar</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section style="text-align: center">
            </section>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
        integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        code = null;
        $('#btn-ticket').click(
            function() {
                email = $('#email').val();
                $('#send-email').text(email);
                // alert(email);
                $.ajax({
                    method: 'GET',
                    url: "/send-code-email/" + email,
                    success: function(response) {
                        code = response;
                    },
                    error: function(response) {
                        console.log("error", response);
                    }
                });
            }
        );
        $('#code').keyup(function() {
            if ($(this).val().length == 4) {
                if (code == null) {
                    alert("ajeita isso depois!");
                    return 0;
                } else if (code == $('#code').val()) {
                    $('#data-payer').submit();
                } else {
                    alert("código invalido")
                }
            }
        });
    </script>
@endsection
