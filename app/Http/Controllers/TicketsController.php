<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $messages = [
            'required' => 'O campo :attribute é obrigatório',
            'max' => 'CPF inválido',
            'min' => 'CPF inválido',
            'min' => 'Cadastre ao meno 1 ingresso'
        ];

        $validator = Validator::make($request->all(), [
            'event_id'=>'required',
            'customer_cpf'=>'required|max:14|min:14',
            'customer_email'=>'required|email',
            'customer_contact'=>'required',
        ],$messages);

        if ($validator->fails()) {
            Alert::warning($validator->errors()->first());
            return redirect()->back();
        }
        $invoice_id = Carbon::now()->timestamp;
        // dd($invoice_id);
        $ticket = Tickets::create($request->except(['_token'])
                +['invoice_id'=>$invoice_id]
        );
        $event = Events::find($ticket->event_id);
        $organizer = User::find($event->user_id);
        $commissions = $event->value_ticket*config('app.commission');
        $total = $event->value_ticket+$commissions;
        //gerar pix
        $px[00]="01";
        $px[26][00]="BR.GOV.BCB.PIX";
        $px[26][01]="60850726352"; #chave pix
        $px[26][02]=$event->name; #descrição
        $px[52]="0000"; //Merchant Category Code “0000” ou MCC ISO18245
        $px[53]="986"; //Moeda, “986” = BRL: real brasileiro - ISO4217
        $px[54]=$total; //Valor da transação, se comentado o cliente especifica o valor da transação no próprio app. Utilizar o . como separador decimal. Máximo: 13 caracteres.
        $px[58]="BR"; //“BR” – Código de país ISO3166-1 alpha 2
        $px[59]="BRENO CAMPOS"; //Nome do beneficiário/recebedor. Máximo: 25 caracteres.
        $px[60]="FORTALEZA"; //Nome cidade onde é efetuada a transação. Máximo 15 caracteres.
        $px[62][05]="***"; //Identificador de transação, quando gerado automaticamente usar ***. Limite 25 caracteres. Vide nota abaixo.
        $pix=montaPix($px);
        $pix.="6304"; //Adiciona o campo do CRC no fim da linha do pix.
        $pix.=crcChecksum($pix); //Calcula o checksum CRC16 e acrescenta ao final.

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrcode = $writer->writeString($pix);
        $data = ['ticket','event','organizer','commissions','qrcode','total'];
        return view('event-checkout',compact($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
