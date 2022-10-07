<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Events::where('active',1)->orderByDesc('created_at')->get();
        $data = ['events'];
        return view('welcome',compact($data));
    }
}
