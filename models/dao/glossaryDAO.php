<?php

namespace models;

include_once "database.php";

class glossaryDAO {

    public function __construct(){}

    public function save(glossary  $obj){
        $database = new database();
        $con = $database->getConTransation();
        $sql = sprintf("INSERT INTO publication  VALUES (null,'%s','%s','%s')",
            database::validate($con, $obj->title),
            database::validate($con, $obj->content),
            database::validate($con, $obj->id_publication)
        );
        $rs = mysqli_query($con, $sql) or die (mysqli_error($con));
        return $rs;
    }

    public function getAll(){
        //...
    }
}

