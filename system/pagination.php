<?php



class pagination{



    public static function previousPage($pagina){
        $pg = ($pagina -1) <= 0 ? 1 : $pagina-1;
        return $pg;
    }

    public static function  nextPage($pagina,$totalPg) {
        $pg = ($pagina + 1) > $totalPg ? 1 : $pagina+1;
        return $pg;
    }


}


?>