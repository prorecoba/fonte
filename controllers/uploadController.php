<?php
include_once "./models/publication.php";
include_once "./models/chapter.php";
include_once "./models/section.php";
include_once "./models/block.php";


if(isset($_POST['title'])){

    #region VARIAVEIS POST DO FORM

    $autor = utf8_encode($_POST['autor']); // PEGA NOME DO AUTOR INFORMADO NO FORMULARIO
    $titlefile = utf8_encode($_POST['title']); // PEGA TITULO INFORMADO NO FORMULARIO
    $descriptionfile = utf8_encode($_POST['description']); //PEGA DESCRICAO INFORMADO NO FORMULARIO
    $linguage = utf8_encode($_POST['language']); // PEGA LINGUAGEM INFORMADO NO FORMULARIO
    $keywords = utf8_encode($_POST['keywords']); // PEGA PALAVRA CHAVES INFORMADO NO FORMULARIO
    $file = $_FILES["file"]; // PEGA O ARQUIVO CARREGADO NO FORMULARIO

    #endregion

    #region ESPECIFICACOES DO ARQUIVO

    $namefile = $_FILES["file"]['name']; // FUNCAO QUE OBTEM O NOME DO AQUIVO CARREGADO
    $extetionfile = explode(".",$namefile); // FUNCAO "EXPLODE" GERA UM ARRAY A PARTIR DE UMA STRING USANDO UM DELIMITADOR PASSADO POR PARAMETRO
    $extetionfile = end($extetionfile); // FUNCAO END PEGA O ULTIMO INDICE DO ARRAY ACIMA QUE CONTEM A EXTENSAO DO ARQUIVO

    #endregion

    $pathFiles = './files/'; //DEFINE O CAMINHO  PARA ONDE VAI O ARQUIVO CARREGADO
    $dir = time().'/'; // CRIA UM TIMESTAMP QUE SERA O NOME DA PASTA DO ARQUIVO SELECIONADO

    $viewAlertas = ""; // VARIAVEL PARA GUARDAR ALERTAS PRA SER USADO NA PAGINA
    $db = new \models\database(); // INSTANCIA A CLASSE DE CONEXAO COM O BANNCO
    $db->beginTransation(); // INICIA UMA TRANSAÇÃO
    try{
        $types = array("application/vnd.oasis.opendocument.text","application/octet-stream"); // DEFINE UMA ARRAY DE TYPES PERMITIDOS
        $extencoes = array("odt","ODT"); // DEFINE UMA ARRAY DE EXTENCOES PERMITIDAS

        if(in_array($file["type"], $types) && in_array($extetionfile,$extencoes)) { // VERIFICA SE O TYPE DO ARQUIVO CONTEM NO ARRAY ASSIM COMO A EXTENCAO NO ARRAY DE EXTENCOES
            createDir($pathFiles.$dir); // CRIA O DIRETORIO COMO NOME DA PASTA
            if (move_uploaded_file($file['tmp_name'], $pathFiles.$dir.$namefile)) { // TENTA COPIAR O ARQUIVO PARA O SERVIDOR SERVIDOR (NOME_TEMPORARIO, CAMINHO COMPLETO PARA O SERVIDOR)
                // SE MOVER COM SUCESSO ENTAO:

                $publication = new \models\publication(); // INSTANCIA UMA PUBLICATION
                $publication->gen_title = $titlefile; // DEFINE O TITULO COM DADOS DO FROM
                $publication->gen_description = $descriptionfile; // DEFINE A DESCRICAO COM DADOS DO FROM
                $publication->gen_language = $linguage; // DEFINE A LINGUAGEM COM DADOS DO FROM
                $publication->gen_keyword = $keywords; // DEFINE AS PALAVRAS CHAVES COM DADOS DO FROM
                $publication->lif_contribute_entity = $autor; // DEFINE O AUTOR COM DADOS DO FROM
                $publication->lif_contribute_date = date('Y-m-d'); // DEFINE A DATA COM DATA ATUAL
                $publication->met_metadataschema = "LOM"; // DEFINE COM VALOR FIXO
                $publication->rights_copyright = "SIM"; // DEFINE COM VALOR FIXO
                $publication->tec_format = "odt"; // DEFINE COM VALOR FIXO
                $publication->url = $dir.$namefile; // DEFINE A URL DO ARQUIVO PRA DOWNLOAD
                $idPub = $publication->save(); // SALVA A PUBLICACAO E RETORNA O ID

                odtExtract($publication->url,$dir); // FUNCAO PARA EXTRAIR OS ARQUIVOS DO .ODT (META, CONTENT...)
                $viewOA = odtFragment($publication->url, $idPub); // FUNCAO PARA FRAGMENTAR

                $db->comitTransation(); // COMITAR TRANSACAO
                $db::closeCon($db->getConTransation()); // FECHAR CONEXAO ABERTA COM A TRANSACAO
            } else {
                throw new Exception("Erro ao carregar aquivo!"); //  SE NAO CONSIGUIR FAZER UPLOAD LANCA UMA EXCECAO
            }
        }else{
            throw new Exception("Erro: ".$file["error"]); // SE NAO VALIDAR O TIPO E A EXTENCAO DO ARQVUI LANCA UMA EXCECAO
        }
    }
    catch(Exception $ex){
        echo $ex->getMessage(); // MOSTRAR MSG DE ERRO DA EXCECAO
        $db->rollbackTransacao($db->getConTransation()); // ROLLBACK
        $db::closeCon($db->getConTransation()); // FECHAR CONECAO DA TRANSACAO
    }

}

#region FUNCTIONS
function createDir($dir){
    if(!file_exists($dir)){ // VERIFICA SE EXISTE ESSE DIRETORIO NO SERVIDOR
        if(!mkdir($dir, 0777)){ // TENTA CRIAR O DIRETORIO CASO NAO EXISTE
            header("Location: ./error&n=1001"); // REDIRECIONA PRA PAGINA DE ERRO
            exit; // SAI DO SCRIPT
        }
    }
}

function odtFragment($urlOdt, $idPub){
    $reader = new XMLReader(); // CRIA O OBJETO XMLREADER QUE VAI TRABALHAR COM O ODT
    $reader->open('zip://'.PATHAPP.'/files/'.$urlOdt.'#content.xml'); // ABRE O DOC .ODT COM PROTOCOLO ZIP ACESSANDO O CONTENT.XML
    $dir = explode("/",$urlOdt); // PEGA O DIRETORIO CRIADO (NOME_PASTA/TIMESTAMP ) PELA URL DO .ODT

    $idCurrentChapter = null;
    $idCurrentSection = null;
    $idCurrentBlock = null;

    $totalFragmentos = 0;
    $totalFragmentosJaExistentes = 0;

    while ($reader->read()) { // LER O ARQUIVO CONTENT ABERTO ACIMA COLOCANDO O PONTEIRO PARA O PROXIMO NO
        $DOMNode = $reader->expand(); // EXPANDE O NODE E RETORNA UM OBJETO DOMNODE
        if($DOMNode->nodeType == XMLReader::ELEMENT && $DOMNode->nodeValue != ""){ // VERIFICA SE EH UMA LINHA XMLReader::ELEMENT E SE NAO ESTA VAZIO
            if($DOMNode->nodeName  == "text:h"){ // VERIFICA SE O NODE E UM HEAD/TITULO
                //CASO SEJA UM TITULO
                if($reader->getAttribute("text:outline-level") == 1){ // VERIFICA O NIVEL DO TITULO (1 = TITULO/CHAPTER, > 1 = SUBTITULOS/SECTION)
                    $chapter = new \models\chapter(); // SENDO NIVEL 1, INSTANCIA UM OBJETO CHAPTER
                    $chapter->id_publication = $idPub; // SETA O ID DA PUBLICATION
                    $chapter->title = $DOMNode->nodeValue; // SETA O TITULO
                    $idCurrentChapter = $chapter->save(); // SALVA E SETA O ID DO CAHPTER CORRENTE
                    $idCurrentSection = null; // TODA VEZ QUE ENTRA EM UM CHAPTER ZERA  A SECTION CORRENTE PARA QUE SE INICIA NOVAMENTE CASO ESSE PROXIMO CHAPTER TEM SECTION
                } else{
                    if($reader->getAttribute("text:outline-level") > 1){ // VERIFICA O NIVEL DO TITULO E MAIOR QUE 1
                        // CASO SEJA, TRATA-SE DE UMA SECTION
                        $section = new \models\section(); // INSTANCIA UMA SECTION
                        $section->title = $DOMNode->nodeValue; // SETA O TITULO
                        $section->id_chapter = $idCurrentChapter; // SETA O CHAPTER QUE ELA PERTENCE
                        $idCurrentSection = $section->save(); // // SALVA  SETA O ID DA SECTION CORRENTE
                    }
                }
            }
            if($DOMNode->nodeName == "text:p" && $DOMNode->nodeValue != ""){ // VERIFICA SE O NODE E UM PARAGRAF/BLOCK
                $block = new \models\block(); // INSTANCIA UM OBJETO BLOCK
                replaceTagsEmpty($DOMNode); // FUNCAO IMPLEMENTADA PRA RESOLVER BUGS DE CONCATENACAO DE STRING (PALAVRAS UNIDAS)
                $block->content = $DOMNode->nodeValue; // SETA O CONTENT DO BLOCK
                $block->id_section = $idCurrentSection; // SETA A SECTION CORRENTE CASO EXISTE, CASO CONTRARIO ESTARA SENTANDO NULL COMO FOI DEFINIDA INICIALMENTE
                if($idCurrentChapter == null){ // VERIFICA SE TEM UM CHAPTER CORRENTE, POIS ACONTECE DE O DOCUMENTO NAO TER O PADRAO COM TITULOS ENTAO O CHAPTER SERA O PRORPIO BLOCK
                    $chapter = new \models\chapter(); // CRIA-SE UM CHAPTER QUE TERA COMO TITULO O TEXTO DO NODE
                    $chapter->id_publication = $idPub; // SETA O ID DA PUBLICATION
                    $chapter->title = "Títulos/Capítulos"; // SETA O TITULO, QUANDO ENTRA NO BLOCK SEM CHAPTER CORRENTE
                    $idCurrentChapter = $chapter->save(); // SETA UM CHAPTER CORRENTE A PARTIR DAQUI DO PRIMEIRO
                }
                $block->id_chapter = $idCurrentChapter; // SETA O ID DO CHAPTER.
                $totalFragmentos++; // INCREMENTA NO TOTAL DE FRAGMENTOS
                if($block->existBlock(utf8_encode($block->content), $idPub)){ // VERIFICA SE O BLOCK JA EXISTE NA BASE DE DADOS
                    $totalFragmentosJaExistentes++; // INCREMENTA NO TOTAL DE FRAGMENTO EXISTENTES CASO RETORNE VERDADEIRO
                }
                $idCurrentBlock = $block->save(); // SALVA O BLOCK E SETA O BLOCK CORRENTE
            }
        }
        if($DOMNode->nodeName == "draw:image"){ // VERIFICA SE O NODE E DO TIPO IMAGE
            $url = $reader->getAttribute("xlink:href"); // PEGAR URL DA IMAGEM PRA SALVAR NO BLOCK
            $block = new \models\block(); // INSTANCIA UM BLOCK
            if($idCurrentBlock != null || $idCurrentBlock != ""){ // VERIFICA SE EXISTE UM BLOCK
                $block->getById($idCurrentBlock); // OBTEM O BLOCK CORRENTE
            }
            $block->url_image = $dir[0]."/".$url; // ADD A INFORMACAO DA URL NO BLOCK
            $block->save(); // ATUALIZA O BLOCK CORRENTE COLOCANDO A IMAGEM
        }
    }
    $oa = array("totalFragmentos" => $totalFragmentos, "totalFragmentosAproveitados" => $totalFragmentosJaExistentes); // CRIA UM VETOR COM OS TOTAIS DE FRAGMENTOS OBTIDOS
    return $oa;
}

function odtExtract($url,$dir){ // FUNCAO QUE EXTRAI O ARQVUIVO PARA O SERVIDOR
    $zip = new ZipArchive; // INSTANCIA A CLASSE ZIPARCHIVE
    $fileOdt = PATHAPP.'/files/'.$url; // PEGA O CAMINHO DO ARQUIVO CONCATENANDO A URL
    $fileZip = PATHAPP.'/files/'.$url.".zip"; // ADD UMA EXTENCAO ZIP NO FINAL (CRIANDO OUTRO CAMINHO)
    copy($fileOdt, $fileZip); // FAZ UMA COPIA DO ARQUIVO PARA UM OUTRO ARQUIVO .ZIP
    if ($zip->open($fileZip)=== TRUE) { // TENTA ABRIR O ZIP
        $zip->extractTo(PATHAPP.'/files/'.$dir); // EXTRAI O ZIP PARA A PASTA
        $zip->close();
    }
}

function replaceTagsEmpty($node){ // FUNCAO PARA INCLUIR ESPACOS PRA EVITAR ERROS NA CONCATENACAO DA STRINGS
    $DOMNodeList = $node->childNodes; // OBTEM OS FILHOS DESSE NODE
    for($i = 0; $i < $DOMNodeList->length; $i++){
        $DOMNode = $DOMNodeList->item($i); // OBTEM UM NODE DA LISTA PELO INDX
        if($DOMNode->hasChildNodes()){ // VERIFICA SE ESSE NODE TEM FILHOS PRA USAR RECURSAO
            replaceTagsEmpty($DOMNode); // RECURSAO
        }else{
            if($DOMNode->nodeName == "text:s" && $DOMNode->nodeValue == ""){ // VERIFICA SE E UMA TAG TEXT:S E ESTA VAZIA
                $DOMNode->nodeValue = " "; // INCLUI UM ESPACO COMO VALOR
            }
        }

    }
}

#endregion

?>