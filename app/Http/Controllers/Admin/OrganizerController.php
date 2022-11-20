<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrganizerController extends Controller
{
    public function panel(){
        $user = Auth::user();
        $events = Events::where('user_id', $user->id)->where('day','>=',Carbon::today())->get();
        $tickets = Tickets::whereIn('event_id',$events->pluck('id'))->where('paid',1)->get();
        $withdraws = Withdraw::whereIn('event_id',$events->pluck('id'))->get();
        $data = ['user', 'events','tickets','withdraws'];
        return view('organizer.panel',compact($data));
    }
    public function updatePix(Request $request){
        User::where('id',Auth::user()->id)->update(['pix'=>$request->pix]);
        Alert::success('Chave PIX atualizada!');
        return redirect()->back();
    }
}
