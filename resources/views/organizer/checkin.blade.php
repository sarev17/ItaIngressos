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
        }

        video {
            max-height: 350px;
            /* transform:scaleX(-1); */
            max-width: 100%;
        }

        #prev {
            transform: scaleX(-1);
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

        .reading {
            display: none;
        }

        /* #cam svg{
                    font-size: 40pt;
                } */
        /* #preview-cam{
                    opacity: 0 ;
                    position: relative;
                } */
        #preview-cam img {
            display: none;
            width: 100%;
            position: absolute;
            z-index: 1;
            opacity: 0.8;
        }

        #line {
            height: 1px;
            background-color: rgb(187, 0, 0);
            width: 90%;
            -webkit-animation: mover 1s infinite alternate;
            animation: mover 2.5s infinite alternate;
        }

        @keyframes mover {
            0% {
                transform: translateY(-30px);
            }

            100% {
                transform: translateY(-200px);
            }
        }
    </style>
    <script type="text/javascript" src="{{ asset('js/scanner/jsqrscanner.nocache.js') }}"></script>
    <center>
        <section class="video">
            <!-- RECOMMENDED if your web app will not function without JavaScript enabled -->
            <noscript>
                <div
                    style="width: 22em; position: absolute; left: 50%; margin-left: -11em; color: red; background-color: white; border: 1px solid red; padding: 4px; font-family: sans-serif">
                    Habilite o javascript para usar essa aplicação;
                </div>
            </noscript>

            <center>
                <section class="video">
                    <br>
                    <div class="panel-content">
                        {{-- <div id="cam"> --}}
                        {{-- <h4>Iniciando camera</h4>
                    <i class="fa-fade fa-solid fa-camera"></i>
                </div> --}}
                        <div id="preview-cam">
                            <h5>Aponte a camera para o QRCODE do ingresso</h5>
                            <img src="{{ asset('img/back-camera.png') }}" alt="">
                            <div class="row-element-set row-element-set-QRScanner">
                                <div class="qrscanner" id="scanner">
                                </div>
                            </div>
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
                                    {{-- <b><span id="qtd">4</span> ingressos</b><br> --}}
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
                        </body>
                </section>
            </center>
            <div class="row-element-set row-element-set-QRScanner">
                <div class="qrscanner" id="scanner">
                </div>
            </div>
            {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
            <script type="text/javascript">
                let scan;

                function onQRCodeScanned(scannedText) {
                    // alert(scan == scannedText);
                    if (scan !== scannedText) {
                        $.ajax({
                                method: 'GET',
                                url: "/ckeckin-ticket/" + scannedText + "?event={{ $_GET['event'] }}",
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
                    }
                    scan = scannedText;
                }

                function provideVideo() {
                    var n = navigator;

                    if (n.mediaDevices && n.mediaDevices.getUserMedia) {
                        return n.mediaDevices.getUserMedia({
                            video: {
                                facingMode: "environment"
                            },
                            audio: false
                        });
                    }

                    return Promise.reject('Your browser does not support getUserMedia');
                }

                function provideVideoQQ() {
                    return navigator.mediaDevices.enumerateDevices()
                        .then(function(devices) {
                            var exCameras = [];
                            devices.forEach(function(device) {
                                if (device.kind === 'videoinput') {
                                    exCameras.push(device.deviceId)
                                }
                            });

                            return Promise.resolve(exCameras);
                        }).then(function(ids) {
                            if (ids.length === 0) {
                                return Promise.reject('Could not find a webcam');
                            }

                            return navigator.mediaDevices.getUserMedia({
                                video: {
                                    'optional': [{
                                        'sourceId': ids.length === 1 ? ids[0] : ids[
                                            1] //this way QQ browser opens the rear camera
                                    }]
                                }
                            });
                        });
                }

                //this function will be called when JsQRScanner is ready to use
                function JsQRScannerReady() {
                    //create a new scanner passing to it a callback function that will be invoked when
                    //the scanner succesfully scan a QR code
                    var jbScanner = new JsQRScanner(onQRCodeScanned);
                    //var jbScanner = new JsQRScanner(onQRCodeScanned, provideVideo);
                    //reduce the size of analyzed image to increase performance on mobile devices
                    jbScanner.setSnapImageMaxSize(300);
                    var scannerParentElement = document.getElementById("scanner");
                    if (scannerParentElement) {
                        //append the jbScanner to an existing DOM element
                        jbScanner.appendTo(scannerParentElement);
                    }
                }
            </script>
        </section>
    @endsection
