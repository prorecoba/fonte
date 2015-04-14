<?php
/**
 * Created by PhpStorm.
 * User: Duda
 * Date: 08/10/14
 * Time: 21:28
 */

namespace models;

include_once "dao/blockDAO.php";

class block {

    public $id_block;
    public $content;
    public $url_image;
    public $id_chapter;
    public $id_section;

    public function __construct(){}

    public function save(){
        $dao = new blockDAO();
        return $dao->save($this);
    }

    public function getById($id){
        $dao = new blockDAO();
        $blk = $dao->getById($id);
        if($blk != null){
            $this->id_block = $blk->id_block;
            $this->content = $blk->content;
            $this->url_image = $blk->url_image;
            $this->id_chapter = $blk->id_chapter;
            $this->id_section = $blk->id_section;
            $return = $this;
        }else{
            $return = null;
        }
        return $return;

    }

    public function getByChapter($id_chapter){
        $dao = new blockDAO();
        $rs = $dao->getByChapter($id_chapter);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function getBySection($id_section){
        $dao = new blockDAO();
        $rs = $dao->getBySection($id_section);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function getBlocksMultimediaByChapter($id_publication){
        $dao = new blockDAO();
        $rs = $dao->getBlocksMultimediaByChapter($id_publication);
        $arrayReturn = array();
        if($rs != null){
            while($item = mysqli_fetch_object($rs)){
                array_push($arrayReturn,$item);
            }
        }
        return $arrayReturn;
    }

    public function existBlock($content, $idPub){
        $dao = new blockDAO();
        $rs = $dao->existBlock($content, $idPub);
        return $rs;
    }

}