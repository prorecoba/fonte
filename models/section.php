<?php
/**
 * Created by PhpStorm.
 * User: Duda
 * Date: 08/10/14
 * Time: 21:35
 */

namespace models;

include_once "dao/sectionDAO.php";

class section {

    public $id_section;
    public $title;
    public $content;
    public $id_chapter;

    public function __construct(){}

    public function save(){
        $dao = new sectionDAO();
        return $dao->save($this);
    }

    public function update($fields,$params,$where){
        $dao = new sectionDAO();
        $dao->update($fields,$params,$where);
    }

    public function getByChapter($id_chapter){
        $dao = new sectionDAO();
        $rs = $dao->getByChapter($id_chapter);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function getById($id){
        $dao = new sectionDAO();
        return $dao->getById($id);
    }
}