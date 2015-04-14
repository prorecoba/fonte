<?php include_once "./controllers/listfilesController.php" ?>

<div class="row">
    <div class="large-12">
        <ul class="breadcrumbs">
            <li><a href="./home">Início</a></li>
            <li class="current"><a href="">Objetos de Aprendizagem</a></li>
        </ul>
    </div>
    <div class="large-8 column">
        <div class="row">
            <table style="width: 100%">
                <tbody>
                    <?php echo $viewListFiles; ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-centered">
            <ul class="pagination">
                <li class="arrow"><a href='<?php echo "./listfiles&pg=".pagination::previousPage($viewPage)  ?>'>&laquo;</a></li>
                <li class="unavailable"><a href=""><?php echo $viewPage ?></a></li>
                <li class="unavailable"><a href="">de</a></li>
                <li class="unavailable"><a href=""><?php echo $viewTotalPage ?></a></li>
                <li class="arrow"><a href='<?php echo "./listfiles&pg=".pagination::nextPage($viewPage, $viewTotalPage)  ?>'>&raquo;</a></li>
            </ul>
        </div>
    </div>
    <div class="large-4 column">
        <a href="./upload" class="button large-12 column" id="botaoTema" >Upload Arquivo</a>
        <div class="panel">
            <p class="text-justify">
                <small>
                    Neste projeto será aceito apenas o formato OpenDocument (ou OpenDocument Format ? ODF).
                    Como aqui trabalharemos com objetos do tipo Publicação, usaremos a extensão .ODT. Extensão esta para documentos de texto.
                    Para um melhor resultado, formate-o usando estilo.
                </small>
            </p>
        </div>
    </div>
</div>