<?php

namespace models;

include_once "dao/chapterDAO.php";

class chapter {

    public $id_chapter;
    public $title;
    public $content;
    public $id_publication;

    public function __construct(){}

    public function save(){
        $dao = new chapterDAO();
        return $dao->save($this);
    }

    public function getArrByPublication($id_publication){
        $dao = new chapterDAO();
        $rs = $dao->getArrByPublication($id_publication);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function getById($id){
        $dao = new chapterDAO();
        return $dao->getById($id);
    }

} 