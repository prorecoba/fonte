<?php

class queryString{

    public static function getPage($get){
        $index = "home.php";
        $diretorio = "views";

        $get= trim($get);
        $get= strip_tags($get);

        if(empty($get)){
            include_once("$diretorio/$index");
        }elseif(preg_match("(http|www|.php|.asp|.net|.gif|.exe|.jpg|./)i",$get)){
            include_once("$diretorio/$index");
        }elseif(!file_exists("$diretorio/$get.php")){
            include_once("$diretorio/$index");
        }else{
            include_once("$diretorio/$get.php");
        }

    }

}

?>