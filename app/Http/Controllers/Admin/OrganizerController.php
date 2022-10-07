<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function panel(){
        $user = Auth::user();
        $data = ['user'];
        return view('organizer.panel',compact($data));
    }
}
