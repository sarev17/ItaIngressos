<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function panel(){
        $user = Auth::user();
        $events = Events::where('user_id', $user->id)->get();
        $data = ['user', 'events'];
        return view('organizer.panel',compact($data));
    }
}
