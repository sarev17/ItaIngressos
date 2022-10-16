@extends('layouts.app')
@section('content')
    <style>
        .bg-green {
            background-color: #78cb78;
        }

        .bg-blue {
            background-color: #bbc0ff;
        }

        .video {
            padding: 20px;
            width: 400px;
        }

        video {
            width: 90%
        }

        #client {
            font-size: 13pt;
        }

        .confirm {
            background-color: #bcf5bc;
            padding: 5px;
            display: none;
        }

        .confirm #message {
            font-size: 15pt;
            color: #155a15
        }

        .used #message {
            font-size: 15pt;
            color: #ce3304
        }

        .used {
            background-color: #ebb76b;
            padding: 5px;
            display: none;
        }
        .unauthorized {
            background-color: #940000;
            padding: 5px;
            display: none;
            color: white;
            font-weight: 600;
        }
        .reading{
            display: none;
        }
        #cam svg{
            font-size: 40pt;
        }
        #preview-cam{
            opacity: 0 ;
            position: relative;
        }
        #preview-cam img{
            width: 325px;
            position: absolute;
            z-index: 1;
            opacity: 0.8;
        }
        #line{
            height: 1px;
            background-color: rgb(187, 0, 0);
            width: 90%;
            -webkit-animation: mover 1s infinite  alternate;
            animation: mover 2.5s infinite  alternate;
        }
        @keyframes mover {
            0% { transform: translateY(-50px); }
            100% { transform: translateY(-180px); }
        }

    </style>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <center>
        <section class="video">
            <br>
            <div class="panel-content">
                <div id="cam">
                    <h4>Iniciando camera</h4>
                    <i class="fa-fade fa-solid fa-camera"></i>
                </div>
                <div id="preview-cam">
                    <h5>Aponte a camera para o QRCODE do ingresso</h5>
                    <img src="{{asset('img/back-camera.png')}}" alt="">
                    <video id="preview"></video>
                    <div id="line"></div>
                </div>
                <br><br>
                <section class="info">
                    <div class="reading">
                        <h3 id="message">Fazendo a Leitura</h3>
                        <h3><i class=" fa-spin fa-solid fa-spinner"></i></h3>
                    </div>
                    <div class="unauthorized">
                        <h3 id="message">Não Autorizado!</h3>
                        <h4>Ingresso Inválido</h4>
                    </div>
                    <div class="confirm">
                        <span id="message"><i class="fa-solid fa-circle-check"></i> Entrada confirmada!</span>
                        <br>
                        <span id="client">
                            <b><span id="qtd">4</span> ingressos</b><br>
                            <b>Nome: </b><span id="name"></span> <br>
                            <b>CPF: </b><span id="document"></span>
                        </span>
                    </div>
                    <div class="used">
                        <span id="message"><i class="fa-solid fa-circle-xmark"></i> Ingresso já usado!</span>
                        {{-- <br>
                        <span id="client">
                            <b><span id="qtd">4</span> ingressos</b><br>
                            <b>Nome: </b><span id="name"></span> <br>
                            <b>CPF: </b><span id="document"></span>
                        </span> --}}
                    </div>

                </section>
                <script type="text/javascript">
                    let scanner = new Instascan.Scanner({
                        video: document.getElementById('preview')
                    });
                    scanner.addListener('scan', function(content) {
                        $.ajax({
                            method: 'GET',
                            url: "/ckeckin-ticket/" + content+"?event={{$_GET['event']}}",
                            success: function(response) {
                                $('.reading').css('display', 'block');
                                $('.used').css('display', 'none');
                                $('.confirm').css('display', 'none');
                                $('.unauthorized').css('display', 'none');
                                setTimeout(function() {
                                    // alert(response['ticket']['customer_name'])
                                    if (response['status'] == 'accepted') {
                                        $('.reading').css('display', 'none');
                                        $('.confirm').css('display', 'block');
                                        $('.used').css('display', 'none');
                                        $('#name').html(response['ticket']['customer_name']);
                                        $('#document').html(response['ticket']['customer_cpf']);
                                        $('.unauthorized').css('display', 'none');

                                    }
                                    if (response['status'] == 'used') {
                                        $('.reading').css('display', 'none');
                                        $('.used').css('display', 'block');
                                        $('.confirm').css('display', 'none');
                                        $('#name').html(response['ticket']['customer_name']);
                                        $('#document').html(response['ticket']['customer_cpf']);
                                        $('.unauthorized').css('display', 'none');
                                    }
                                    if (response['status'] == 'unauthorized') {
                                        $('.reading').css('display', 'none');
                                        $('.used').css('display', 'none');
                                        $('.confirm').css('display', 'none');
                                        $('.unauthorized').css('display', 'block');

                                    }
                                    if (response['status'] == 'erro') {
                                        $('.reading').css('display', 'none');
                                        $('.used').css('display', 'none');
                                        $('.confirm').css('display', 'none');
                                        $('.unauthorized').css('display', 'block');

                                    }
                                    console.log(response);
                                }, 1000);
                            },
                            error: function(response) {
                                console.log("error", response);
                            }
                        });
                    });
                    Instascan.Camera.getCameras().then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                            $('#cam').css('display','none');
                            $('#preview-cam').css('opacity',1);

                        } else {
                            alert('Não há cameras disponíveis! Atualize a página')
                        }
                    }).catch(function(e) {
                        alert(e);
                    });
                </script>
                </body>
        </section>
    </center>
    </section>


    </div>
@endsection
