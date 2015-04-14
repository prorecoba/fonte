<?php
include_once "./models/publication.php";
include_once "./system/pagination.php";

$publication = new \models\publication();
$viewPage = isset($_GET["pg"]) ? $_GET["pg"] : 1;
$QtdPublication = $publication->getAllQtd();
$viewTotalPage = ceil($QtdPublication/6);
$publics = $publication->getAllPagination($viewPage);
$viewListFiles="";


if(count($publics) > 0){
    foreach($publics as $public){
        $viewListFiles .= "
        <tr>
            <td class='large-8 column'>
                <span>".utf8_decode($public->gen_title)."</span><br/>
                <span><small>".utf8_decode($public->lif_contribute_entity).", ".date("d-m-Y",strtotime($public->lif_contribute_date))."</small></span>
            </td>
            <td class='large-2 column'>
                <a href='./file&id=$public->id_publication'>Visualizar</a>
            </td>
            <td class='large-2 column'>
                <a href='downloads.php?f=$public->url' target='_blank'>Download</a>
            </td>
        </tr>
    ";
    }
}else{
    $viewListFiles = "<p>Lista Valizia</p>";
}



?>



