<?php
    use App\Models\Events;
    $input = $_GET['event'];
    if($input!==null){
        echo json_encode(Events::where('name','like','%'.$input.'%')->where('active',1)->orWhere('city',$input)->get());
    }else{
        echo json_encode(Events::where('active',1)->get());
    }
?>
