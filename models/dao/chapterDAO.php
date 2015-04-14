<?php

namespace models;

include_once "database.php";

class chapterDAO {

    public function __construct(){}

    public function save(chapter  $obj){
        $database = new database();
        $con = $database->getConTransation();
        $sql = sprintf("INSERT INTO chapter  VALUES (null,'%s','%s','%s')",
            database::validate($con,$obj->title),
            database::validate($con,$obj->content),
            database::validate($con,$obj->id_publication)
        );
        $rs = mysqli_query($con,$sql) or die (mysqli_error($con)."Erro ao inserir chapter: sql => ".$sql);
        return mysqli_insert_id($con);
    }

    public function getArrByPublication($id_publication){
        $con = database::connect();
        $id_publication = database::validate($con, $id_publication);
        $sql = "SELECT * FROM chapter WHERE id_publication = $id_publication";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function getById($id){
        $con = database::connect();
        $id = database::validate($con, $id);
        $sql = "SELECT * FROM chapter WHERE id_chapter = $id";
        $rs = mysqli_query($con, $sql)  or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? mysqli_fetch_object($rs) : null;
        database::closeCon($con);
        return $return;
    }
}

