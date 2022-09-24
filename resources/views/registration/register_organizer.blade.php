@extends('layouts.app')
@section('content')
    <div class="flex center">
        <div class="panel-form">
            <div class="row-form center">
                <h3>CADASTRO DE USUÁRIO</h3>
            </div>
            <br>
            <form class="formSub" action="{{route('registeruser.store')}}" method="post">
                @csrf
                <div class="row-form">
                    <label for="name">Nome</label>
                    <input required name="name" type="text">
                </div>
                <div class="row-form">
                    <label for="contact">Telefone</label>
                    <input data-mask="(00) 0 0000-0000" required name="contact" class="contact" type="text">
                </div>
                <div class="row-form">
                    <label for="agency">Nome da Agência/Empresa</label>
                    <input required name="agency" type="text">
                </div>
                <div class="row-form">
                    <label for="email">E-mail</label>
                    <input required name="email" type="email">
                </div>
                <div class="row-form">
                    <label for="password">Senha</label>
                    <input required name="password" type="password">
                </div>
                <div class="row-form">
                    <label for="confirm_password">Confirmar Senha</label>
                    <input required name="confirm_password" type="password">
                </div>
                <br>
                <div class="row-form center">
                    <button class="load w-100 btn btn-primary" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('.load').attr("disabled", true);
    </script>
@endsection
