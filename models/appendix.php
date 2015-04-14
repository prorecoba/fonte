<?php
/**
 * Created by PhpStorm.
 * User: Duda
 * Date: 08/10/14
 * Time: 21:47
 */

namespace models;

include_once "dao/appendixDAO.php";

class appendix {


    public $id_appendix;
    public $title;
    public $content;
    public $id_publication;

    public function __construct(){}

    public function insert(){
        $dao = new appendixDAO();
        $dao->insert($this);
    }

    public function update($fields,$params,$where){
        $dao = new appendixDAO();
        $dao->update($fields,$params,$where);
    }


}