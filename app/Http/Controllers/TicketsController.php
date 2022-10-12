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
        $name = explode(' ',$request->customer_name);
        $event = Events::find($request->event_id);
        $commissions = $event->value_ticket*config('app.commission');
        $total = $event->value_ticket+$commissions;
        $payer = array(
            'first_name'=>$name[0],
            'last_name'=>isset($name[1]) ? $name[1] : '',
            'email'=>$request->customer_email
        );
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
        $ticket = Tickets::where('customer_cpf',$request->customer_cpf)
            ->where('paid',0)->where('event_id',$event->id)->first();
        // dd($ticket);
        if($ticket == null){
            $payment = createPayment($event,$payer,$total);
            dd($payment);
            if(isset($payment->message)){
                $error = translateMesagesErrors($payment->message);
                Alert::warning($error);
                return redirect()->back();
            }
            $ticket = Tickets::create([
                'invoice_id'=>$payment->id,
                'event_id'=>$event->id,
                'customer_name'=>$request->customer_name,
                'customer_cpf'=>$request->customer_cpf,
                'customer_email'=>$request->customer_email,
                'customer_contact'=>$request->customer_contact,
                'ticket_url'=>$payment->point_of_interaction->transaction_data->ticket_url,
                'ticket_code'=>$payment->point_of_interaction->transaction_data->qr_code_base64,
                'qrcode'=>$payment->point_of_interaction->transaction_data->qr_code,
                'price'=>$event->value_ticket
            ]);
        }

        $organizer = User::find($event->user_id);
        // //gerar pix
        // $px[00]="01";
        // $px[26][00]="BR.GOV.BCB.PIX";
        // $px[26][01]="60850726352"; #chave pix
        // $px[26][02]=$event->name; #descrição
        // $px[52]="0000"; //Merchant Category Code “0000” ou MCC ISO18245
        // $px[53]="986"; //Moeda, “986” = BRL: real brasileiro - ISO4217
        // $px[54]=$total; //Valor da transação, se comentado o cliente especifica o valor da transação no próprio app. Utilizar o . como separador decimal. Máximo: 13 caracteres.
        // $px[58]="BR"; //“BR” – Código de país ISO3166-1 alpha 2
        // $px[59]="BRENO CAMPOS"; //Nome do beneficiário/recebedor. Máximo: 25 caracteres.
        // $px[60]="FORTALEZA"; //Nome cidade onde é efetuada a transação. Máximo 15 caracteres.
        // $px[62][05]="***"; //Identificador de transação, quando gerado automaticamente usar ***. Limite 25 caracteres. Vide nota abaixo.
        // $pix=montaPix($px);
        // $pix.="6304"; //Adiciona o campo do CRC no fim da linha do pix.
        // $pix.=crcChecksum($pix); //Calcula o checksum CRC16 e acrescenta ao final.

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrcode = $writer->writeString($ticket->qrcode);
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
