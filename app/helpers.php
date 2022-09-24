<?php

use RealRashid\SweetAlert\Facades\Alert;

function saveImageLocal($name,$img){
    // Define um aleatório para o arquivo baseado no timestamps atual
    $name = $name.'-'.uniqid(date('HisYmd'));
    $name = str_replace(' ','-',$name);
    // Recupera a extensão do arquivo
    $extension = $img->extension();

    // Define finalmente o nome
    $nameFile = "{$name}.{$extension}";

    // Faz o upload:
    $upload = $img->storeAs('posters', $nameFile);
    // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
    // Verifica se NÃO deu certo o upload (Redireciona de volta)
    return $upload;
    if ( !$upload ){
        Alert::danger('Falha no Upload','Tente uma imagem em um formato diferente');
        return redirect()->back();
    }
}
