<?php

namespace models;

include_once "database.php";

class publicationDAO {

    public function __construct(){}

    public function save(publication  $obj){
        $database = new database();
        $con = $database->getConTransation();
        $sql = sprintf("INSERT INTO publication  VALUES (null,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
            database::validate($con, $obj->url),
            database::validate($con, $obj->gen_description),
            database::validate($con, $obj->gen_keyword),
            database::validate($con, $obj->gen_language),
            database::validate($con, $obj->gen_title),
            database::validate($con, $obj->lif_contribute_date),
            database::validate($con, $obj->lif_contribute_entity),
            database::validate($con, $obj->met_metadataschema),
            database::validate($con, $obj->rights_copyright),
            database::validate($con, $obj->tec_format)
            // nao usado
            /*
            database::validate($obj->annot_date_),
            database::validate($obj->annot_description_),
            database::validate($obj->annot_entity_),
            database::validate($obj->class_description_),
            database::validate($obj->class_keyword_),
            database::validate($obj->class_purpose_),
            database::validate($obj->class_source_),
            database::validate($obj->class_taxon_entry_),
            database::validate($obj->class_taxon_id_),
            database::validate($obj->educ_context_),
            database::validate($obj->educ_description_),
            database::validate($obj->educ_difficult_),
            database::validate($obj->educ_intendedenduserrole_),
            database::validate($obj->educ_interactivitylevel_),
            database::validate($obj->educ_interactivitytype_),
            database::validate($obj->educ_language_),
            database::validate($obj->educ_learningresourcetype_),
            database::validate($obj->educ_semanticdensity_),
            database::validate($obj->educ_typicalagerange_),
            database::validate($obj->educ_typicallearningtime_),
            database::validate($obj->gen_aggregationlevel),
            database::validate($obj->gen_coverage_),
            database::validate($obj->gen_identifier_catalog_),
            database::validate($obj->gen_structure_),
            database::validate($obj->lif_contribute_role_),
            database::validate($obj->lif_status_),
            database::validate($obj->lif_version_),
            database::validate($obj->met_contribute_date_),
            database::validate($obj->met_contribute_entity_),
            database::validate($obj->met_contribute_role_),
            database::validate($obj->met_contribute_catalog_),
            database::validate($obj->met_contribute_entry_),
            database::validate($obj->met_language_),
            database::validate($obj->relation_kind),
            database::validate($obj->rel_res_description_),
            database::validate($obj->rel_res_identifier_catalog_),
            database::validate($obj->rel_res_identifier_entry_),
            database::validate($obj->rights_cost_),
            database::validate($obj->rights_description_),
            database::validate($obj->rights_duration_),
            database::validate($obj->tec_installationremarks_),
            database::validate($obj->tec_location_),
            database::validate($obj->tec_otherplataformrequirement_),
            database::validate($obj->tec_req_orcomposite_maximunve_),
            database::validate($obj->tec_req_orcomposite_minimunve_),
            database::validate($obj->tec_req_orcomposite_name),
            database::validate($obj->tec_req_orcomposite_type_),
            database::validate($obj->tec_size_)
                */
        );
        $rs = mysqli_query($con, $sql) or die (mysqli_error($con));
        return mysqli_insert_id($con);
    }

    public function getAllPagination($pagina){
        $con = database::connect();
            $pag = database::validate($con, $pagina);
            $limit = 6;
            $indice = ($pag * $limit) - $limit;
            $sql = "SELECT * FROM publication  ORDER BY id_publication DESC LIMIT $indice, $limit ";
            $rs = mysqli_query($con, $sql) or die (mysqli_error($con));
            $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function getAllLimited($limit){
        $con = database::connect();
        $sql = "SELECT * FROM publication  ORDER BY id_publication DESC LIMIT 0, $limit";
        $rs = mysqli_query($con, $sql); //or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }

    public function getAllQtd(){
        $con = database::connect();
        $sql = "SELECT COUNT(*) as cont FROM publication";
        $rs = mysqli_query($con, $sql);
        $return = mysqli_fetch_object($rs);
        database::closeCon($con);
        return $return->cont;
    }

    public function getById($id){
        $con = database::connect();
        $id = database::validate($con, $id);
        $sql = "SELECT * FROM publication WHERE id_publication = $id";
        $rs = mysqli_query($con, $sql);
        $rt = mysqli_num_rows($rs) > 0 ? mysqli_fetch_object($rs) : null;
        database::closeCon($con);
        return $rt;
    }

    public function search($str){
        $con = database::connect();
        $str = database::validate($con, $str);
        $sql = "
          SELECT
            p.id_publication as id,
            p.gen_title as titulo,
            p.lif_contribute_entity as autor,
            p.gen_description as descricao,
            p.lif_contribute_date as date,
            p.url as url,
            s.title as secao_titulo,
            c.title as cap_titulo,
            b.content as block_content

          FROM publication p
          LEFT JOIN chapter c ON p.id_publication = c.id_publication
          LEFT JOIN section s ON c.id_chapter = s.id_chapter
          LEFT JOIN block b ON c.id_chapter = b.id_chapter
          WHERE
	        p.gen_title LIKE '%$str%' ||
            p.gen_description LIKE '%$str%' ||
	        p.lif_contribute_entity LIKE '%$str%' ||
	        s.title LIKE '%$str%' ||
	        c.title LIKE '%$str%' ||
	        b.content LIKE '%$str%'
          GROUP BY p.id_publication
        ";
        $rs = mysqli_query($con, $sql) or die (mysqli_error($con));
        $return = mysqli_num_rows($rs) > 0 ? $rs : null;
        database::closeCon($con);
        return $return;
    }
}

