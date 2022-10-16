<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'Ita Ingressos') }}</title>
    <style>
        body{
        }
        h1{
            font-weight: 600;
        }
        .panel-mail{
            text-align: center;
            background-color: white;
            width: 50%;
            padding: 30px;
            /* border-radius: 18px; */
            margin: 50px 0;
        }
        .qrcode{
            width:15rem;
        }
        span,small{
            display: block;
        }
        @media(max-width:420px){
            .panel-mail{
                width: unset;
                height: unset;
            }
        }
        .container-mail{
            font-family: 'Montserrat', sans-serif;
            background-color: rgb(212, 212, 212);
        }
    </style>
</head>
<body>
    <section class="container-mail">
        <center>
            <div class="panel-mail">
                <header>
                    <table>
                        <tr style="width: 100%">
                            <td><picture><img width="150px" src="https://i.ibb.co/tZt8rcw/logo.png" alt=""></picture></td>
                            <td style="width: 100%;text-align:right;color:rgb(6, 83, 197)"><h4>Sua diversão mais próxima de você</h4></td>
                        </tr>
                    </table>
                </header>
                <hr>
                <h1>Confirme seu email!</h1>
                <span>Digite o esse código abaixo na plataforma para prosseguir com a compra</span>
                <br>
                <center><h2>{{$code}}</h2></center><br>
                
                <br><br>
                <span>Boa diversão :)</span><br>
                <span>Equipe ItaIngressos</span>

            </div>
        </center>
    </section>
</body>
</html>
