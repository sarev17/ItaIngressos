@extends('layouts.app')
@section('content')
    <div class="panel-content">
        <section class="center">
            <nav class="action-events">
                <a class="btn btn-primary" href="{{route('event.create')}}">
                    <i class="fa-solid fa-calendar-plus"></i>
                    <span>Cadastrar Evento</span>
                </a>
                <a class="btn btn-primary" href="{{route('event.create')}}">
                    <i class="fa-solid fa-calendar-plus"></i>
                    <span>Editar Evento</span>
                </a>
            </nav>
        </section>
    </div>
@endsection
