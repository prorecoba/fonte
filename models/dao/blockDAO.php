<?php

namespace models;

include_once "database.php";

class blockDAO {

    public $con;

    public function __construct(){
       // $this->con = database::conect();
    }


    public function __destruct(){
       // $close = database::closeCon($this->con);
    }

    public function save(block  $obj){
        $database = new database();
        $con = $database->getConTransation();

        $content = $obj->content  == null ? "null" : database::validate($con, $obj->content);
        $urlImage = $obj->url_image  == null ? null : database::validate($con, $obj->url_image);
        $idChapter = $obj->id_chapter == null ? "null" : database::validate($con, $obj->id_chapter);
        $id_section = $obj->id_section  == null ? "null" : database::validate($con, $obj->id_section);

        if($obj->id_block == null){
            $sql = "INSERT INTO block  VALUES (null,'$content','$urlImage',$idChapter,$id_section)";
            $rs = mysqli_query($con, $sql) or die (mysqli_error($con)."Erro ao inserir block: sql =>  ".$sql);
            $return = mysqli_insert_id($con);
        }else{
            $id =  database::validate($con, $obj->id_block);
            $sql = "UPDATE block  SET content = '$content', url_image = '$urlImage', id_chapter = $idChapter, id_section = $id_section
                    WHERE id_block = $id";
            $rs = mysqli_query($con, $sql) or die (mysqli_error($con)."ERRO AO ATUALIZAR BLOCK");
            $return = mysqli_affected_rows($con) >= 1 ? true : false;
        }
        return $return;
    }

    public function getById($id){
        $con = database::connect();
        $id = database::validate($con, $id);
        $sql = "SELECT * FROM block WHERE id_block = $id";
        $rs = mysqli_query($con, $sql) or die (mysqli_error($this->con)."ERRO AO OBTER BLOCK POR ID: sql-> ".$sql);
        $obj =  mysqli_num_rows($rs) >= 1 ? mysqli_fetch_object($rs) : null;
        database::closeCon($con);
        return $obj;
    }

    public function getByChapter($id_chapter){
        $con = database::connect();
        $id_chapter = database::validate($con, $id_chapter);
        $sql = "SELECT b.*, (select COUNT(a.id_block) from block a WHERE a.content like CONCAT('%',b.content,'%')) as ocorrencias
                FROM block b
                WHERE id_chapter = $id_chapter AND id_section is null";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function getBySection($id_section){
        $con = database::connect();
        $id_section = database::validate($con, $id_section);
        $sql = "SELECT b.*, (select COUNT(a.id_block) from block a WHERE a.content like CONCAT('%',b.content,'%')) as ocorrencias
                FROM block b
                WHERE id_section = $id_section";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function getBlocksMultimediaByChapter($id_chapter){
        $con = database::connect();
        $id_chapter = database::validate($con, $id_chapter);
        $sql = "SELECT * FROM block WHERE id_chapter = $id_chapter and url_image <> ''";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function existBlock($content, $idPub){
        $con = database::connect();
        $content = mysqli_real_escape_string($con,$content);
        $sql = "SELECT b.id_block
                FROM block b, chapter c, publication p
                WHERE  b.content ='".utf8_decode($content)."'
                AND b.id_chapter = c.id_chapter AND c.id_publication <> p.id_publication";
        $rs = mysqli_query($con,$sql);
        $retorno = mysqli_num_rows($rs) > 0 ? true : false;
        database::closeCon($con);
        return $retorno;
    }
}

