<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(Hash::make($request->password));
        $messages = [
            'unique' => 'O :attribute já está em uso',
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute não pode ser menor que :min caracteres'
        ];

        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'email' =>'required|email',
            'contact'=>'required',
            'password'=>'required|min:8',
            'confirm_password'=>'required|min:8',
            'agency'=>'required',
        ],$messages);

        if ($validator->fails()) {
            Alert::warning($validator->errors()->first());
            return redirect()->back();
        }
        if($request->password != $request->confirm_password){
            Alert::warning('As senhas não são iguais!');
            return redirect()->back();
        }

        User::create($request->except(['_token','confirm_password','password'])
                                        +['password'=>Hash::make($request->password)]
        );
        Alert::success("Cadastro efetuado.");
        return redirect()->route('home');

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

    public function searchEmail($email){
        $exists = User::where('email', '=', $email)->exists();
        return $exists;
    }
}
