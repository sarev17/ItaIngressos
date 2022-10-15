<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class IuguActionsController extends Controller
{
    public function paymentTicketConfirm( Request $request){
        // dd($request->all());
        $invoice_id = $request->invoice_id;
        $code = $invoice_id.'-'.bin2hex(random_bytes(12));
        $ticket = Tickets::where('invoice_id',$invoice_id)->first();
        if($ticket != null){
            $ticket->update(['ticket_url'=>config('app.url').'/api/ckeckin-ticket?ticket_code='.$code,'ticket_code'=>$code]);
            sendTicketMail($ticket->id);
            Alert::success('Pagamento confirmado','Você receberá um email com os dados do ingresso');
            return redirect()->route('index');
        }
        // dd($ticket);
    }
}
