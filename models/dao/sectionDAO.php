<?php

namespace models;

include_once "database.php";

class sectionDAO {

    public function __construct(){}

    public function save(section  $obj){
        $database = new database();
        $con = $database->getConTransation();
        $title = $obj->title == null ? "null" : database::validate($con, $obj->title);
        $content = $obj->content  == null ? "null" : database::validate($con, $obj->content);
        $idChapter = $obj->id_chapter  == null ? "null" : database::validate($con, $obj->id_chapter);

        $sql = "INSERT INTO section  VALUES (null,'$title','$content',$idChapter)";

        $rs = mysqli_query($con, $sql) or die (mysqli_error($con)."Erro ao inserir section: sql => ".$sql);
        return mysqli_insert_id($con);
    }

    public function getByChapter($id_chapter){
        $con = database::connect();
        $id_chapter = database::validate($con, $id_chapter);
        $sql = "SELECT * FROM section WHERE id_chapter = $id_chapter";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function getById($id){
        $con = database::connect();
        $id = database::validate($con, $id);
        $sql = "SELECT * FROM section WHERE id_section = $id";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? mysqli_fetch_object($rs) : null;
        database::closeCon($con);
        return $return;
    }
}

