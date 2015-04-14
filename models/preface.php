<?php

namespace models;

include_once "dao/prefaceDAO.php";

class preface {

    public $id_preface;
    public $title;
    public $content;
    public $id_publication;

    public function __construct(){}

    public function insert(){
        $dao = new prefaceDAO();
        $dao->insert($this);
    }

    public function update($fields,$params,$where){
        $dao = new prefaceDAO();
        $dao->update($fields,$params,$where);
    }
} 