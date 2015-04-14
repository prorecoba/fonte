<?php

namespace models;

include_once "dao/glossaryDAO.php";

class glossary {

    public $id_glossary;
    public $title;
    public $content;
    public $id_publication;

    public function __construct(){}

    public function insert(){
        $dao = new glossaryDAO();
        $dao->insert($this);
    }

    public function update($fields,$params,$where){
        $dao = new glossaryDAO();
        $dao->update($fields,$params,$where);
    }
} 