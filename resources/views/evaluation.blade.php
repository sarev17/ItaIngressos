<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .evaluation {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1rem;
            height: 100vh;
            font-size: 11pt;
        }

        .evaluation img {
            width: 15rem;
        }

        .evaluation article img {
            filter: grayscale(1);
            opacity: 0.6;
        }

        .evaluation article img:hover {
            scale: 1.2;
            filter: grayscale(0);
            opacity: 1;
        }

        .evaluation .rad {
            opacity: 0;
        }

        .ev-content {
            width: 450px;
            padding: 1rem;
            border-radius: 11px;
            background-color: white;
            min-height: 500px
        }

        .ev-content article {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        textarea {
            width: 90%;
            height: 5rem;
            border: solid 1px #070488;
            font-size: 14pt;

        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        form button {
            margin-top: 11px;
            width: 8rem;
            height: 2rem;
            font-weight: 600;
            background-color: #070488;
            color: white;
            border: none;
            font-family: 'Montserrat', sans-serif;
        }
        .evaluation article img{
            width: 3rem;
        }
        @media(max-width: 470px){
            .ev-content{
                width: unset;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
        integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
</head>

<body>


    <section class="evaluation">
        <div class="ev-content">
            <figure><img src="https://www.itaingressos.fun/img/logo.png" alt=""></figure>
            <br>
            <p>Obrigado por comprar no ItaIngressos. O que achou da gente?</p>
            <br>
            <form action="" method="post">
                <article>
                    <label for="rate0"><img class="emojis" src="https://i.ibb.co/b2jx0jZ/e0.png" alt=""></label>
                    <input class="rad" type="radio" name="rate" id="rate0" value="0">
                    <label for="rate1"><img class="emojis" src="https://i.ibb.co/1rkyz19/e1.png" alt=""></label>
                    <input class="rad" type="radio" name="rate" id="rate1" value="1">
                    <label for="rate2"><img class="emojis" src="https://i.ibb.co/9vkbT3P/e2.png" alt=""></label>
                    <input class="rad" type="radio" name="rate" id="rate2" value="2">
                    <label for="rate3"><img class="emojis" src="https://i.ibb.co/pvvmdYq/e3.png" alt=""></label>
                    <input class="rad" type="radio" name="rate" id="rate3" value="3">
                    <label for="rate4"><img class="emojis" src="https://i.ibb.co/tQ9F2bN/e4.png" alt=""></label>
                    <input class="rad" type="radio" name="rate" id="rate4" value="4">
                </article>
                <br>
                <p>Sua opinião é muito importante para nós.</p>
                <textarea name="msg" id="msg" cols="30"></textarea>
                <button class="submit">Enviar</button>
            </form>
        </div>
        <br>
    </section>
</body>
<script>
    $('.emojis').click(function() {
        $('.emojis').css('filter', 'grayscale(1)').css('scale', '1').css('opacity','0.6');
        $(this).css('filter', 'grayscale(0)').css('scale', '1.2').css('opacity','1');
    });
    $('.submit').click(function(){
        $(this).hmtl('Enviado');
    });
</script>

</html>
