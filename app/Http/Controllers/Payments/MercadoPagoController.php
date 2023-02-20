<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\Logs;
use App\Models\Tickets;
use App\Models\Webhook;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MercadoPago\Card;
use RealRashid\SweetAlert\Facades\Alert;

class MercadoPagoController extends Controller
{
    public function verifyPayment(Request $request)
    {
        $ticket = Tickets::where('invoice_id', $request->id)->first();
        return $ticket->paid;
    }
    public function confirmPayment(Request $request)
    {
        try {
            $json = json_encode($request->all());
            if (isset($request->resource)) {
                $payment = statusPayment($request->id);
                $json = json_decode($payment);
                Webhook::create(['invoice_id' => $request->id, 'json' => $payment]);
                if ($json->status == 'approved' || config('app.ambiente_teste')) {
                    $ticket = Tickets::where('invoice_id', $request->id)->first();
                    $ticket->update(['paid' => 1]);
                    $code = $request->id . '-' . bin2hex(random_bytes(12));
                    if ($ticket != null) {
                        $ticket->update(['ticket_code' => $code]);
                        sendTicketMail($ticket->id);
                    }
                }else{
                    // return config('app.ambiente_teste');
                }
            }else{
                $json_webhook = json_encode($request->all());
                Webhook::create(['invoice_id' => $request->data_id, 'json' => $json_webhook]);
            }
            return http_response_code(200);
        } catch (Exception $e) {
            Logs::create(['type'=>'Checkout','request'=>$e->getMessage()]);
            return http_response_code(500);
        }
    }
}
