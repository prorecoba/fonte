<?php
include_once "./models/publication.php";
include_once "./models/chapter.php";
include_once "./models/section.php";
include_once "./models/block.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $publications = new \models\publication();
    $publication =  $publications->getById($id);
    $viewTitleFile = utf8_decode($publication->gen_title);
    $viewLinkDownload = "downloads.php?f=".$publication->url;
    $viewHtmlChaptersAcordion="";
    $viewHtmlMultimidiaBlocks="";

    $chapters =  new \models\chapter();
    $arrChapters = $chapters->getArrByPublication($publication->id_publication);
    if(count($arrChapters) > 0){
        foreach($arrChapters as $chapter){
            //buscar os blocos do capitulo sem section
            $blocksChapter = getBlocksByChapter($chapter->id_chapter);
            $viewHtmlChaptersAcordion .="
                <div class='right options pd-5'>
                    <a href='download.php?id=$chapter->id_chapter&t=0&ext=xml' target='_parent'>
                        <img src='./images/downloadXML.png' width='36' />
                    </a>
                    <a href='download.php?id=$chapter->id_chapter&t=0&ext=json' target='_parent'>
                        <img src='./images/downloadJSON.png' width='36' />
                    </a>
                    <a href='download.php?id=$chapter->id_chapter&t=0&ext=txt' target='_parent'>
                        <img src='./images/download.png' width='36' />
                    </a>
                </div>

                <dd class='accordion-navigation chapter' >
                    <a href='#chapter$chapter->id_chapter'>$chapter->title</a>
                    <div id='chapter$chapter->id_chapter' class='content'>
                         $blocksChapter
                    </div>
                </dd>
                <hr/>
            ";

            $sections = new \models\section();
            $arrSections = $sections->getByChapter($chapter->id_chapter);
            if(count($arrSections) > 0){
                foreach($arrSections as $section){
                    //buscar os blocos da section
                    $blocksSection = getBlocksBySection($section->id_section);
                    $viewHtmlChaptersAcordion .="
                        <div class='right options pd-5'>
                            <a href='download.php?id=$section->id_section&t=1&ext=xml' target='_parent'>
                                <img src='./images/downloadXML.png' width='36' />
                            </a>
                            <a href='download.php?id=$section->id_section&t=1&ext=json' target='_parent'>
                                <img src='./images/downloadJSON.png' width='36' />
                            </a>
                            <a href='download.php?id=$section->id_section&t=1&ext=txt' target='_parent'>
                                <img src='./images/download.png' width='36' />
                            </a>
                        </div>
                        <dd class='accordion-navigation chapter' >
                            <a href='#section$section->id_section'>$section->title</a>
                            <div id='section$section->id_section' class='content'>
                                $blocksSection
                            </div>
                        </dd>
                        <hr/>
                    ";
                }
            }
        }
    }

    $blocksmediali = getBlocksMultimidiaByPub($publication->id_publication);
    if($blocksmediali != ""){
        $viewHtmlMultimidiaBlocks .= "
            <ul class='small-block-grid-2'>
                $blocksmediali
            </ul>
        ";
    }


}

#region FUNCTIONS
function getBlocksByChapter($id_chapter){
    $return = "";
    $blocks = new \models\block();
    $arrBlock = $blocks->getByChapter($id_chapter);
    if(count($arrBlock) > 0){
        foreach($arrBlock as $block){
            if($block->url_image == null || $block->url_image == ""){
                $return .=  "
                    <div class='paragraph'>
                        <a class='link-paragraph' href='#block$block->id_block'>".substr($block->content,0,50)."...</a>
                        <div class='content-paragraph' id='block$block->id_block'>
                            <p>$block->content</p>
                        </div>
                        <div class='option-paragraph'>
                            <a href='download.php?id=$block->id_block&t=2&ext=xml' target='_parent'>
                                <small>XML</small>
                            </a>
                            <a href='download.php?id=$block->id_block&t=2&ext=json' target='_parent'>
                                <small>JSON</small>
                            </a>
                            <a href='download.php?id=$block->id_block&t=2&ext=txt' target='_parent'>
                                <small>TXT</small>
                            </a>
                            <small>Numero de ocorrencias desse fragmento: ($block->ocorrencias)</small>
                        </div>
                    </div>
                    <hr/>
                    ";

                //$return .= "<p>".$block->content."</p>";
            }else{
                $return .= "
                <a class='th' href='./files/$block->url_image'>
                  <img src='./files/$block->url_image'>
                </a>";
            }
        }
    }
    return $return;
}

function getBlocksBySection($id_section){
    $return = "";
    $blocks = new \models\block();
    $arrBlock = $blocks->getBySection($id_section);
    if(count($arrBlock) > 0){
        foreach($arrBlock as $block){
            if($block->url_image == null || $block->url_image == ""){
                $return .=
                    "
                    <div class='paragraph'>
                        <a class='link-paragraph' href='#block$block->id_block'>".substr($block->content,0,50)."...</a>
                        <div class='content-paragraph' id='block$block->id_block'>
                            <p>$block->content</p>
                        </div>
                        <div class='option-paragraph'>
                            <a href='download.php?id=$block->id_block&t=2&ext=xml' target='_parent'>
                                <small>XML</small>
                            </a>
                            <a href='download.php?id=$block->id_block&t=2&ext=json' target='_parent'>
                                <small>JSON</small>
                            </a>
                            <a href='download.php?id=$block->id_block&t=2&ext=txt' target='_parent'>
                                <small>TXT</small>
                            </a>
                            <small>Numero de ocorrencias desse fragmento: ($block->ocorrencias)</small>
                        </div>
                    </div>
                    <hr/>
                    ";
            }else{
                $return .= "
                <a class='th' href='./files/$block->url_image'>
                  <img src='./files/$block->url_image'>
                </a>";
            }
        }
    }
    return $return;
}

function getBlocksMultimidiaByPub($id_publication){
    $return = "";
    $blocks = new \models\block();
    $chapters = new \models\chapter();
    $arrChapter = $chapters->getArrByPublication($id_publication);
    if(count($arrChapter) > 0){
        foreach($arrChapter as $chapter){
            $arrBlock = $blocks->getBlocksMultimediaByChapter($chapter->id_chapter);
            if(count($arrBlock)){
                foreach($arrBlock as $block){
                    $return .="
                        <li>
                            <a class='th' href='./files/$block->url_image'>
                                <img src='./files/$block->url_image'>
                            </a>
                        </li>
                    ";
                }
            }
        }
    }
    return $return;
}

?>

