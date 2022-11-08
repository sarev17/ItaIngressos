<?php

use App\Mail\SendMailTicket;
use App\Models\Events;
use App\Models\Logs;
use App\Models\Tickets;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

function saveImageLocal($name, $img)
{
    // Define um aleatório para o arquivo baseado no timestamps atual
    $name = $name . '-' . uniqid(date('HisYmd'));
    $name = str_replace(' ', '-', $name);
    // Recupera a extensão do arquivo
    $extension = $img->extension();

    // Define finalmente o nome
    $nameFile = "{$name}.{$extension}";

    // Faz o upload:
    $upload = $img->storeAs('posters', $nameFile);
    // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
    // Verifica se NÃO deu certo o upload (Redireciona de volta)
    return $upload;
    if (!$upload) {
        Alert::danger('Falha no Upload', 'Tente uma imagem em um formato diferente');
        return redirect()->back();
    }
}

########################### funções pix ##################################
function montaPix($px)
{
    /*
    # Esta rotina monta o código do pix conforme o padrão EMV
    # Todas as linhas são compostas por [ID do campo][Tamanho do campo com dois dígitos][Conteúdo do campo]
    # Caso o campo possua filhos esta função age de maneira recursiva.
    #
    # Autor: Eng. Renato Monteiro Batista
    */
    $ret = "";
    foreach ($px as $k => $v) {
        if (!is_array($v)) {
            if ($k == 54) {
                $v = number_format($v, 2, '.', '');
            } // Formata o campo valor com 2 digitos.
            else {
                $v = remove_char_especiais($v);
            }
            $ret .= c2($k) . cpm($v) . $v;
        } else {
            $conteudo = montaPix($v);
            $ret .= c2($k) . cpm($conteudo) . $conteudo;
        }
    }
    return $ret;
}

function remove_char_especiais($txt)
{
    /*
    # Esta função retorna somente os caracteres alfanuméricos (a-z,A-Z,0-9) de uma string.
    # Caracteres acentuados são convertidos pelos equivalentes sem acentos.
    # Emojis são removidos, mantém espaços em branco.
    #
    # Autor: Eng. Renato Monteiro Batista
    */
    return preg_replace('/\W /', '', remove_acentos($txt));
}

function remove_acentos($texto)
{
    /*
    # Esta função retorna uma string substituindo os caracteres especiais de acentuação
    # pelos respectivos caracteres não acentuados em português-br.
    #
    # Autor: Eng. Renato Monteiro Batista
    */
    $search = explode(",", "à,á,â,ä,æ,ã,å,ā,ç,ć,č,è,é,ê,ë,ē,ė,ę,î,ï,í,ī,į,ì,ł,ñ,ń,ô,ö,ò,ó,œ,ø,ō,õ,ß,ś,š,û,ü,ù,ú,ū,ÿ,ž,ź,ż,À,Á,Â,Ä,Æ,Ã,Å,Ā,Ç,Ć,Č,È,É,Ê,Ë,Ē,Ė,Ę,Î,Ï,Í,Ī,Į,Ì,Ł,Ñ,Ń,Ô,Ö,Ò,Ó,Œ,Ø,Ō,Õ,Ś,Š,Û,Ü,Ù,Ú,Ū,Ÿ,Ž,Ź,Ż");
    $replace = explode(",", "a,a,a,a,a,a,a,a,c,c,c,e,e,e,e,e,e,e,i,i,i,i,i,i,l,n,n,o,o,o,o,o,o,o,o,s,s,s,u,u,u,u,u,y,z,z,z,A,A,A,A,A,A,A,A,C,C,C,E,E,E,E,E,E,E,I,I,I,I,I,I,L,N,N,O,O,O,O,O,O,O,O,S,S,U,U,U,U,U,Y,Z,Z,Z");
    return remove_emoji(str_replace($search, $replace, $texto));
}

function remove_emoji($string)
{
    /*
    # Esta função retorna o conteúdo de uma string removendo oas caracteres especiais
    # usados para representação de emojis.
    #
    */
    return preg_replace('%(?:
    \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
  | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
  | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
 )%xs', '  ', $string);
}


function cpm($tx)
{
    /*
     # Esta função auxiliar retorna a quantidade de caracteres do texto $tx com dois dígitos.
     #
     # Autor: Renato Monteiro Batista
     */
    if (strlen($tx) > 99) {
        die("Tamanho máximo deve ser 99, inválido: $tx possui " . strlen($tx) . " caracteres.");
    }
    /*
     Não aprecio o uso de die no código, é um tanto deselegante pois envolve matar.
     Mas considerando que 99 realmente é o tamanho máximo aceitável, estou adotando-o.
     Mas aconselho que essa verificação seja feita em outras etapas do código.
     Caso não tenha entendido a problemática consulte  a página 4 do Manual de Padrões para Iniciação do Pix.
     Ou a issue 4 deste projeto: https://github.com/renatomb/php_qrcode_pix/issues/4
     */
    return c2(strlen($tx));
}

function c2($input)
{
    /*
     # Esta função auxiliar trata os casos onde o tamanho do campo for < 10 acrescentando o
     # dígito 0 a esquerda.
     #
     # Autor: Renato Monteiro Batista
     */
    return str_pad($input, 2, "0", STR_PAD_LEFT);
}


function crcChecksum($str)
{
    /*
    # Esta função auxiliar calcula o CRC-16/CCITT-FALSE
    #
    # Autor: evilReiko (https://stackoverflow.com/users/134824/evilreiko)
    # Postada originalmente em: https://stackoverflow.com/questions/30035582/how-to-calculate-crc16-ccitt-in-php-hex
    */
    // The PHP version of the JS str.charCodeAt(i)
    function charCodeAt($str, $i)
    {
        return ord(substr($str, $i, 1));
    }

    $crc = 0xFFFF;
    $strlen = strlen($str);
    for ($c = 0; $c < $strlen; $c++) {
        $crc ^= charCodeAt($str, $c) << 8;
        for ($i = 0; $i < 8; $i++) {
            if ($crc & 0x8000) {
                $crc = ($crc << 1) ^ 0x1021;
            } else {
                $crc = $crc << 1;
            }
        }
    }
    $hex = $crc & 0xFFFF;
    $hex = dechex($hex);
    $hex = strtoupper($hex);
    $hex = str_pad($hex, 4, '0', STR_PAD_LEFT);

    return $hex;
}

function sendTicketMail($ticket_id)
{
    try{
        $ticket = Tickets::find($ticket_id);
        $image = QrCode::format('png')
            ->size(300)->errorCorrection('H')
            ->generate($ticket->ticket_code);
        $output_file = '/public/tickets/' . $ticket->id . md5($ticket->invoice_id) . '.png';
        Storage::disk('local')->put($output_file, $image);
        $output_file = 'storage' . str_replace('/public', '', $output_file);
        // dd($output_file);
        Mail::to($ticket->customer_email)->send(new SendMailTicket($ticket, $output_file));
        return 1;
    }catch(Exception $e){
        Logs::create(['type'=>'sendEmail','request'=>$e->getMessage()]);
        return 0;
    }
}

function createPayment(Events $event, $payer, $total)
{

    // dd(config('app.url').'/api/confirm-payment');
    // $payload = array(
    //     'description' => 'Compra de Ingresso',
    //     'installments' => 1,
    //     'payer' => array(
    //         'email' => $payer['email'],
    //         'first_name' => $payer['first_name'],
    //         'last_name' => $payer['last_name'],
    //     ),
    //     'notification_url' => config('app.webhook'),
    //     'payment_method_id' => 'pix',
    //     'binary_mode' =>true,
    //     'transaction_amount'=>$total
    // );
    $payload = array (
        'additional_info' =>
        array (
          'items' =>
          array (
            0 =>
            array (
              'id' => 'IG'.Carbon::now()->timestamp,
              'title' => 'Venda de ingresso',
              'description' => $event->name.'-'.$event->day,
            //   'picture_url' => 'https://http2.mlstatic.com/resources/frontend/statics/growth-sellers-landings/device-mlb-point-i_medium@2x.png',
              'category_id' => 'entertainment',
              'quantity' => 1,
              'unit_price' => $total,
            ),
          ),
          'payer' =>
          array (
            'first_name'=> $payer['first_name'],
            'last_name' => $payer['last_name'],
            'email'     => $payer['email'],
          ),
          'shipments' =>
          array (
            'receiver_address' =>
            array (
              'zip_code' => '62011-020',
              'state_name' => 'Ceará',
              'city_name' => 'Sobral',
              'street_name' => 'R. Joaquim Ribeiro',
              'street_number' => 220,
            ),
          ),
          'barcode' =>
          array (
          ),
        ),
        'description' => 'Compra de ingresso',
        'external_reference' => 'IG'.Carbon::now()->timestamp,
        'installments' => 1,
        'metadata' =>
        array (
        ),
        'payer' =>
        array (
          'entity_type' => 'individual',
          'type' => 'customer',
          'identification' =>
          array (
          ),
        ),
        'payment_method_id' => 'pix',
        'transaction_amount' => $total,
        'notification_url' => config('app.webhook'),
        'binary_mode' =>true,
    );
    // dd(json_encode($payload));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $headers = array();
    $headers[] = 'Authorization: Bearer '.config('app.mercado_pago_access_use');
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    // dd($result);
    curl_close($ch);
    $payment = json_decode($result);
    return $payment;
}

function statusPayment($id)
{
    // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/'.$id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Authorization: Bearer '.config('app.mercado_pago_access_use');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    return $result;
}

function translateMesagesErrors(String $message)
{
    // dd($message);
    switch ($message) {
        case "The customer can't be equal to the collector.":
            return 'O dados do cliente e recebedor não podem ser iguais';
            break;
        default:
            return $message;
            break;
    }
}
