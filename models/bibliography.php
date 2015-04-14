<?php
/**
 * Created by PhpStorm.
 * User: Duda
 * Date: 08/10/14
 * Time: 21:45
 */

namespace models;

include_once "dao/bibliographyDAO.php";

class bibliography {

    public $id_bibliography;
    public $title;
    public $content;
    public $id_publication;

    public function __construct(){}

    public function save(){
        $dao = new bibliographyDAO();
        return $dao->save($this);
    }

    public function getAll(){
        $dao = new bibliographyDAO();
        return $dao->getAll();
    }
} 