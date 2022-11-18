@extends('layouts.app')
@section('content')
<style>
    label{
        display: block;
    }
    @media(max-width:420px){
        .form-register{
            max-width: 100%
        }
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
                <div class="grid-l">
                    <div>
                        <label for="name">Estado</label>
                        <select required name='uf'>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>
                    <div>
                        <label for="name">Cidade</label>
                        <input type="text" required name='city'>
                    </div>
                </div>
                <div>
                    <label for="name">Local do Evento</label>
                    <input type="text" required name='location'>
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
