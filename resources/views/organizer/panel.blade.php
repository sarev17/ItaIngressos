@extends('layouts.app')
@section('content')
<style>
    .table-events{
        overflow-x: auto;
    }
    .bg-green{
        background-color: #78cb78;
    }
    .bg-blue{
        background-color: #bbc0ff;
    }
    td a{
        width: fit-content;
    }
    #chave_pix{
        width: 100%;
        height: 2rem;
        padding: 1rem;
    }
    @media(max-width:420px){
        .cards{
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }
        .navbarmenu{
            flex-direction: column;
        }
        .login{

        }

    }
</style>
    <div class="panel-content">
        <section>
            <div class="container">
                <section class="btn-event" style="text-align: end;">
                    <nav class="action-events">
                        <a class="btn btn-primary btn-sm" href="{{ route('event.create') }}">
                            <i class="fa-solid fa-calendar-plus"></i>
                            <span style="font-size: 10pt">Cadastrar Evento</span>
                        </a>
                    </nav>
                </section>
                <br>
                <section class="data-panel">
                    <div class="cards">
                        <div class="card bg-green">
                            <section class="">
                               <div>
                                   <span class="big">Vendas</span>
                                    <span class="info"><b>R$ {{number_format($tickets->sum('price'),2,',','.')}}</b></span>
                               </div>
                               <div>
                                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                               </div>
                            </section>
                            <footer>
                                @if (isset($tickets[0]))
                                    <span>REF: {{date('m/Y',strtotime($tickets[0]->updated_at))}} á {{date('m/Y',strtotime('today'))}}</span>
                                @endif
                            </footer>
                        </div>
                        <div class="card bg-blue">
                            <section class="">
                               <div>
                                   <span class="big">Recebido</span>
                                    <span class="info">R$ {{number_format($withdraws->sum('withdraw_value'),2,',','.')}}</span>
                                    <br>
                                    <span>A enviar: <b>R$ {{number_format($tickets->sum('price')-$withdraws->sum('withdraw_value'),2,',','.')}}</b></span>
                               </div>
                               <div>
                                <i class="fa-sharp fa-solid fa-building-columns"></i>
                               </div>
                            </section>
                            <footer>
                                <a href="">Histórico</a>
                            </footer>
                        </div>
                        <div class="card">
                            <section class="">
                               <div>
                                    <span class="big">Eventos</span>
                                    <br>
                                    <span><b>Disponíveis: </b>{{$events->count()}}</span>
                                    <span><b>Vendas: </b>{{$tickets->count()}}</span>
                               </div>
                               <div>
                                <i class="fa-solid fa-user-group"></i>
                               </div>
                            </section>
                            <footer>
                                <span>REF: {{date('m/Y',strtotime($events[0]->updated_at))}} à {{date('m/Y',strtotime('today'))}}</span>
                            </footer>
                        </div>
                        <div class="card">
                            <section class="">
                               <div>
                                    <span class="big">Meus Dados</span>
                                    <br>
                                    <span>Nome: <b>{{Auth::user()->name}}</b></span>
                                    <span>Chave PIX: <b>{{Auth::user()->pix}}</b></span>
                               </div>
                            </section>
                            <footer>
                                <a data-toggle="modal" data-target="#exampleModal" href="">Editar</a>
                            </footer>
                        </div>
                    </div>
                </section>
                <br><br>
                <center>
                    <h3>Dados dos seus eventos</h3>
                </center>
                <section class="table-events">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nome do evento</th>
                                <th scope="col">Ingressos vendidos</th>
                                <th scope="col">Preço atual</th>
                                <th scope="col">Total apurado</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <th scope="row">{{ $event->name }}</th>
                                    <td>{{ $event->tickets->where('paid', 1)->count() }}</td>
                                    <td>R$ {{ number_format($event->value_ticket, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($event->tickets->where('paid', 1)->sum('price'), 2, ',', '.') }}
                                    </td>
                                    <td><a href="" class="btn btn-sm btn-primary"><i class="fa-solid fa-file-pdf"></i> Lista</a></td>
                                    <td><a href="/checkin?event={{$event->id}}" class="btn btn-sm btn-primary"><i class="fa-sharp fa-solid fa-qrcode"></i> Validar ingressos</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Atualização</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updatePix" action="/update-pix" method="post">
            @csrf
            <label for="pix">Insira sua chave PIX</label>
            <input type="text" name="pix" id="chave_pix">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button form="updatePix" type="submit" class="btn btn-primary">Atualizar</button>
        </div>
      </div>
    </div>
  </div>
@endsection
