<?php include_once "./controllers/homeController.php" ?>

<div class="row">
    <div class="large-8 column">
        <ul class="breadcrumbs">
            <li class="current"><a href="./home">Postagens Recentes</a></li>
        </ul>
        <table style="width: 100%">
            <tbody>
                <?php echo $viewList ?>
            </tbody>
        </table>
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


