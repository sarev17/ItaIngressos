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
            'amount_ticket' => 'required|min:1',
            'uf'=>'required',
            'city'=>'required',
            'location'=>'required',
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
        $data = ['event','commissions','total'];
        return view('ticketpay',compact($data));
    }

}
