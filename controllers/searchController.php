<?php
include_once "./models/publication.php";

$str = isset($_POST["str"]) ? $_POST["str"] : "";
$viewListResult = "Nenhum resultado encontrado!";

$publications = new \models\publication();
$arrayPublications = $publications->search($str);

if(count($arrayPublications) > 0){
    $viewListResult = "<ul class='side-nav' >";
    foreach($arrayPublications as $public){
        $viewListResult .= "
        <tr>
            <td class='large-8 column'>
                <span>".substr(utf8_decode($public->block_content), 0, 100)."...</span><br/>
                <span><small>".utf8_decode($public->autor).", ".date("d-m-Y",strtotime($public->date))."</small></span>
            </td>
            <td class='large-2 column'>
                <a href='./file&id=$public->id'>Visualizar</a>
            </td>
            <td class='large-2 column'>
                <a href='downloads.php?f=$public->url' target='_blank'>Download</a>
            </td>
        </tr>";


       /* $viewListResult .=
            "
                <li>
                    <a href='./file&id=$public->id'>".
                        utf8_decode($public->titulo)."
                        <br/>
                        <span style='color: #333 '>
                            ".
                                substr(utf8_decode($public->block_content), 0, 150) ."
                                ...
                        </span>
                        <br/>
                        <span style='color: #333 '><small>$public->autor, ".date("d-m-Y",strtotime($public->date))."</small></span>
                    </a>
                    <hr style='margin: 5px 0 5px 0' />
                </li>
            ";*/
    }
    $viewListResult .= "</ul>";
}