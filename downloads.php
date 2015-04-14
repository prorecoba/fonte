<?php
$file = isset($_GET["f"]) ? './files/'.$_GET["f"] : null;

if(isset($file) && file_exists($file)){
// faz o teste se a variavel não esta vazia e se o arquivo realmente existe
    switch(strtolower(substr(strrchr(basename($file),"."),1))){
            // verifica a extensão do arquivo para pegar o tipo
        case "pdf": $tipo="application/pdf";
            break;
        case "exe": $tipo="application/octet-stream";
            break;
        case "odt": $tipo="application/octet-stream";
            break;
        case "zip": $tipo="application/zip";
            break;
        case "doc": $tipo="application/msword";
            break;
        case "xls": $tipo="application/vnd.ms-excel";
            break;
        case "ppt": $tipo="application/vnd.ms-powerpoint";
            break;
        case "gif": $tipo="image/gif";
            break;
        case "png": $tipo="image/png";
            break;
        case "jpg": $tipo="image/jpg";
            break;
        case "mp3": $tipo="audio/mpeg";
            break;
        case "php":
        // deixar vazio por seurança
        case "htm":
        // deixar vazio por seurança
        case "html":
        // deixar vazio por seurança
    }
    header("Content-Type: ".$tipo);
    header("Content-Length: ".filesize($file));
    header("Content-Disposition: attachment; filename=".basename($file));
    readfile($file);
    exit;
}else{
    echo "Arquivo não encontrado";
}