<?php

namespace models;

include_once "database.php";

class appendixDAO {

    public function __construct(){}

    public function save(appendix  $obj){
        $database = new database();
        $con = $database->getConTransation();
        $sql = sprintf("INSERT INTO publication  VALUES (null,'%s','%s','%s')",
            database::validate($con, $obj->title),
            database::validate($con, $obj->content),
            database::validate($con, $obj->id_publication)
        );
        $rs = mysqli_query($con, $sql) or die (mysql_error($con));
        return $rs;
    }

    public function getAll(){
        //...
    }
}

