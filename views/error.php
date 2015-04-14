<?php

$arrayErrors = array(
    "1001" => "Não foi possível criar o diretorio ",
    "1002" => "Foi encontrada uma pasta como nome igual, por favor mude o nome do arquivo"
);

$n = isset($_GET["n"]) ? $_GET["n"] : null;
if($n){

echo "<div class='row'>
        <div class='large-12 column'>
            <p>$arrayErrors[$n]
        </div>
     </div>
     ";

}