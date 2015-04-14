<?php

namespace models;

include_once "dao/publicationDAO.php";

class publication {

    #region PROPRIEDADES

    public  $id_publication;
    public  $url;
    public  $gen_description;
    public  $gen_keyword;
    public  $gen_language;
    public  $gen_title;
    public  $lif_contribute_date;
    public  $lif_contribute_entity;
    public  $met_metadataschema;
    public  $rights_copyright;
    public  $tec_format;

    #endregion

    public function __construct(){}

    #region METODOS

    public function save(){
        $dao = new publicationDAO();
        return $dao->save($this);
    }

    public function getAllPagination($pag){
        $dao = new publicationDAO();
        $rs = $dao->getAllPagination($pag);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function getAllLimited($limit){
        $dao = new publicationDAO();
        $rs = $dao->getAllLimited($limit);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function getAllQtd(){
        $dao = new publicationDAO();
        return $dao->getAllQtd();
    }

    public function getById($id){
        $dao = new publicationDAO();
        return $dao->getById($id);
    }

    public function search($str){
        $dao = new publicationDAO();
        $rs = $dao->search($str);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }
    #endregion

}

?>
