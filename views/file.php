<?php include_once "./controllers/fileController.php" ?>

<div class="row">
    <div class="large-12">
        <ul class="breadcrumbs">
            <li><a href="./home">Inicio</a></li>
            <li><a href="./listfiles">Objetos de Aprendizagem</a></li>
            <li class="current"><a href="">Arquivo</a></li>
        </ul>
    </div>
    <h4><?php echo $viewTitleFile ?></h4>
    <a href='<?php echo $viewLinkDownload ?>' target='_blank'>Download do arquivo completo</a>
    <br/>
    <br/>
    <div class="large-6 column">
        <h5>Fragmentos</h5>
        <hr/>
        <div class="large-12" id="chapterSection">

            <dl class="accordion" data-accordion>
                <?php
                    if($viewHtmlChaptersAcordion != ""){
                        echo utf8_decode($viewHtmlChaptersAcordion);
                    }else{
                        echo "
                            <p >
                                Não foi encontrado nenhum capitulo para esse doc.
                            </p>
                        ";
                    }
                ?>

            </dl>

        </div>
    </div>
    <div class="large-6 column">
        <h5>Multimídias</h5>
        <hr/>
        <div class="large-12 column">
            <?php echo $viewHtmlMultimidiaBlocks != '' ? $viewHtmlMultimidiaBlocks : 'Lista Vazia!'; ?>
        </div>


    </div>
</div>


<!--
<div class="right options pd-5"><a href="#"><img src="./images/download.png" width="32" /></a></div>
<dd class="accordion-navigation chapter" >
    <a href="#panel1">Titulo chapter ou section aqui 1 Titulo chapter</a>
    <div id="panel1" class="content active">
        <p>blocks em paragrafos aqui</p>
        <p>blocks em paragrafos aqui</p>
        <p>blocks em paragrafos aqui</p>
    </div>
</dd>
<hr/>

<div class="right options pd-5"><a href="#"><img src="./images/download.png" width="32" /></a> </div>
<dd class="accordion-navigation chapter" >
    <a href="#panel2">Titulo chapter ou section aqui 2 Titulo chapter</a>
    <div id="panel2" class="content">
        <p>blocks em paragrafos aqui</p>
        <p>blocks em paragrafos aqui</p>
        <p>blocks em paragrafos aqui</p>
    </div>
</dd>
<hr/>

<div class="right options pd-5"><a href="#"><img src="./images/download.png" width="32" /></a></div>
<dd class="accordion-navigation chapter" >
    <a href="#panel3">Titulo chapter ou section aqui 3 Titulo chapter</a>
    <div id="panel3" class="content">
        <p>blocks em paragrafos aqui</p>
        <p>blocks em paragrafos aqui</p>
        <p>blocks em paragrafos aqui</p>
    </div>
</dd>
<hr/>
-->