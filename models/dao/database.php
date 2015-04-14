<?php

namespace models;

define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DB_", "projectodt");

class database{

    public static $conTransacao;

    public function beginTransation(){
        self::$conTransacao = self::connect();
        mysqli_autocommit(self::$conTransacao,false);
    }

    public function comitTransation(){
        mysqli_commit(self::$conTransacao);
    }

    public function rollbackTransacao(){
        mysqli_rollback(self::$conTransacao);
    }

    public  function getConTransation(){
        return self::$conTransacao ;
    }



    public static function connect(){
        $con = mysqli_connect(HOST,USER,PASSWORD, DB_) or die ("Nao Foi Possivel conectar ao banco de dados verifique!");
        //$selectdb = mysqli_select_db($con, DB_);
        if($con == null){echo "con esta vazia"; }
        return $con;
    }

    public static  function closeCon($con){
        $close = mysqli_close($con);
    }

    public static function validate($con,$str){
        $retrn = null;
        if($str != "" && $str != null){
            $retrn = mysqli_real_escape_string($con,$str);
        }
        return $retrn;
    }
}



?>