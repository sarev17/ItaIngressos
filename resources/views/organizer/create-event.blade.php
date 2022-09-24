@extends('layouts.app')
@section('content')
<style>
    label{
        display: block;
    }
</style>

    <div class="flex-m center">
        <section class="form-register">
            <header>
                <a href="/organizer/panel"><i class="fa-solid fa-circle-xmark"></i></a>
                <span>Cadastro de Evento</span>
                <i class="fa-solid fa-calendar-check"></i>
            </header>
            <form action="{{route('event.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="file flex" for="poster">
                        <label for="poster">Poster do Evento <i class="fa-solid fa-cloud-arrow-up"></i></label>
                        <input type="file" required name='poster' id="poster">
                    </div>
                </div>
                <div>
                    <img width="100%" src="" alt="" id="preview-image">
                </div>
                <div>
                    <label for="name">Nome do Evento</label>
                    <input type="text" required name='name'>
                </div>
                <div class="grid-r">
                    <div>
                        <label for="day">Dia</label>
                        <input type="date" required name='day'>
                    </div>
                    <div>
                        <label for="start">Hora de Início</label>
                        <input placeholder="00:00" class="time" type="text" required name='start'>
                    </div>
                </div>
                <div class="grid-half">
                    <div>
                        <label for="value_ticket">Valor da entrada</label>
                        <input class="money" type="text" required name='value_ticket'>
                    </div>
                    <div>
                        <label for="amount_ticket">Quantidade de Ingressos</label>
                        <input type="number" required name='amount_ticket'>
                    </div>
                </div>
                <div>
                    <label for="info">Informações Adicionais</label>
                    <textarea rows="4" cols="50" name='info'></textarea>
                </div>
                <button id="submit" type="submit">Cadastrar</button>
            </form>
        </section>
    </div>
<script>
    const input = document.querySelector('#poster');
    input.addEventListener('change', function(e) {
        const tgt = e.target || window.event.srcElement;

    const files = tgt.files;
    const fr = new FileReader();

    fr.onload = function () {
        document.querySelector('#preview-image').src = fr.result;
    }

    fr.readAsDataURL(files[0]);
    });
</script>
@endsection
