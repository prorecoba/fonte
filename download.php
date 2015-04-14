<?php
include_once "models/publication.php";
include_once "models/chapter.php";
include_once "models/section.php";
include_once "models/block.php";

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$tipo = isset($_GET["t"]) ? $_GET["t"] : "";
$ext = isset($_GET["ext"]) ? $_GET["ext"] : "";

$blocks = new \models\block();


if($tipo == 0){
    $chapters = new \models\chapter();
    $chapter = $chapters->getById($id);
    $title = $chapter->title;
    $arrayBlocks = $blocks->getByChapter($id);
}
if($tipo == 1){
    $sections = new \models\section();
    $section = $sections->getById($id);
    $title = $section->title;
    $arrayBlocks = $blocks->getBySection($id);
}
if($tipo == 2){
    $block = new \models\block();
    $block = $block->getById($id);
    $arrayBlocks[] = $block;
    $title = "";
}

if(count($arrayBlocks) > 0){

    if($ext == "xml"){
        $file = "./files/tmp/".time().".xml";
        $contentFile = gerarContentFileXml($arrayBlocks, $title);
    }
    if($ext == "json"){
        $file = "./files/tmp/".time().".json";
        $contentFile = gerarContentFileJson($arrayBlocks, $title);
    }
    if($ext == "txt"){
        $file = "./files/tmp/".time().".txt";
        $contentFile = gerarContentFileTxt($arrayBlocks, $title);
    }
    $extfile = fopen($file, "a") or die();
    $write = fwrite($extfile, $contentFile);
    download($file);
    unlink($file);
}

function download($path, $fileName = '' ){

    if( $fileName == '' ){
        $fileName = basename( $path );
    }

    header("Content-Type: application/force-download");
    header("Content-type: application/octet-stream;");
    header("Content-Length: " . filesize( $path ) );
    header("Content-disposition: attachment; filename=" . $fileName );
    header("Pragma: no-cache");
    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    readfile( $path );
    flush();
}
function gerarContentFileXml($arrayBlocks, $title){
    $retorno = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
    $retorno .= "<chapter_section>";
        $retorno .= "<title>".$title."</title>\r\n";
        foreach($arrayBlocks as $block){
            $retorno .= "<block>".$block->content."</block>\r\n";
        }
    $retorno .= "</chapter_section>\r\n";
    return $retorno;
}
function gerarContentFileJson($arrayBlocks, $title){
    $jsonChapterSection = '{"cahpter_section":'."\r\n".'{"title": "'.utf8_decode($title).'"'."\r\n";
                                    for($i =0; $i < count($arrayBlocks); $i++){
                                        $content = utf8_decode($arrayBlocks[$i]->content);
                                        $jsonChapterSection .= ',"'.$i.'": { "block": "'.$content.'"}'."\r\n";
                                    }
    $jsonChapterSection .=     '}'."\r\n";
    $jsonChapterSection .= '}';

    return $jsonChapterSection;
}
function gerarContentFileTxt($arrayBlocks, $title){
    $return = utf8_decode($title)."\r\n";
    foreach($arrayBlocks as $block){
        $return .= utf8_decode($block->content)."\r\n";
    }
    return $return;
}



?>