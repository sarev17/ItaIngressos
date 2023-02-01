<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Itaingressos</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;600&display=swap" rel="stylesheet">
    <style>
        a {
            text-decoration: none;
            background-color: #10108a;
            padding: 8px;
            border-radius: 5px;
            color: white;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #d2d2d2;
        }

        section {
            border-radius: 13px;
            padding: 37px;
            width: fit-content;
            background-color: white;
        }

        section img {
            width: 15rem;
        }
        section div{
            text-align: left;
        }
    </style>
</head>

<body>
    <center>
        <section>
            <img src="https://www.itaingressos.fun/img/logo.png" alt="">
            <div>
                <h1>Olá, {{$name}}</h1>
                <p>Ficamos felizes em tê-lo conosco. Que tal deixar uma sugestão? É rapidinho, só clicar no botão abaixo
                    :)
                </p>
                <br>
                <a href="{{config('app.url')}}/avalie-nos/{{$invoice}}">Deixe uma sugestao.</a>
            </div>
        </section>
    </center>
</body>

</html>
