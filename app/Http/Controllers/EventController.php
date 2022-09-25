<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class EventController extends Controller
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
        $organizer = Auth::user();
        $data = ['organizer'];
        return view('organizer.create-event',compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(Auth::user()->id);
        $messages = [
            'required' => 'O campo :attribute é obrigatório',
            'mimes' => 'Formatos suportados (jpeg,png,jpg)',
            'max' => 'Horário inválido',
            'min' => 'Cadastre ao meno 1 ingresso'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start' => 'required|max:5',
            "day" => 'required',
            "value_ticket" => 'required',
            'amount_ticket' => 'required|min:1'
        ],$messages);

        if ($validator->fails()) {
            Alert::warning($validator->errors()->first());
            return redirect()->back();
        }

        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
        //    $upload = saveImageLocal($request->name,$request->poster);
        $upload = 'storage/'.$request->file('poster')->store('posters', 'public');
            // dd($upload);
           $price = explode('R$ ',$request->value_ticket)[1];
           $price = floatval(str_replace(',','.',$price));

           Events::create($request->except(['_token','value_ticket','poster'])
                +['value_ticket'=>$price,'user_id'=>Auth::user()->id,'poster'=>$upload]
            );
            Alert::success('Evento Salvo');
            return redirect()->back();
        }else{
            Alert::danger('Falha no Upload','A imagem inserida não é válida.');
            return redirect()->back();
        }
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

    public function detail(Request $request){
        $event = Events::find($request->id);
        $commissions = $event->value_ticket*config('app.commission');
        $total = $event->value_ticket+$commissions;

        //gerar pix
        $px[00]="01";
        $px[26][00]="BR.GOV.BCB.PIX";
        $px[26][01]="joaobatistavasc1104@gmail.com"; #chave pix
        $px[26][02]=$event->name; #descrição
        $px[52]="0000"; //Merchant Category Code “0000” ou MCC ISO18245
        $px[53]="986"; //Moeda, “986” = BRL: real brasileiro - ISO4217
        $px[54]=$total; //Valor da transação, se comentado o cliente especifica o valor da transação no próprio app. Utilizar o . como separador decimal. Máximo: 13 caracteres.
        $px[58]="BR"; //“BR” – Código de país ISO3166-1 alpha 2
        $px[59]="JOAO BATISTA"; //Nome do beneficiário/recebedor. Máximo: 25 caracteres.
        $px[60]="SOBRAL"; //Nome cidade onde é efetuada a transação. Máximo 15 caracteres.
        $px[62][05]="***"; //Identificador de transação, quando gerado automaticamente usar ***. Limite 25 caracteres. Vide nota abaixo.
        $pix=montaPix($px);
        $pix.="6304"; //Adiciona o campo do CRC no fim da linha do pix.
        $pix.=crcChecksum($pix); //Calcula o checksum CRC16 e acrescenta ao final.

        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrcode = $writer->writeString($pix);
        $data = ['event','commissions','total','qrcode'];
        return view('ticketpay',compact($data));
    }
}
