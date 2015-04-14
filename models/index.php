<?php

namespace models;

include_once "dao/indexDAO.php";

class index {

    public $id_index;
    public $title;
    public $content;
    public $id_publication;

    public function __construct(){}

    public function insert(){
        $dao = new indexDAO();
        $dao->insert($this);
    }

    public function update($fields,$params,$where){
        $dao = new indexDAO();
        $dao->update($fields,$params,$where);
    }
} 