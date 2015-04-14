<?php include_once "./controllers/searchController.php" ?>

<div class="row">
    <div class="large-8 column">
        <h4>Resultado da pesquisa</h4>
        <table style="width: 100%">
            <tbody>
                <?php echo $viewListResult ?>
            </tbody>
        </table>


    </div>
    <div class="large-4 column">
        <a href="./upload" class="button large-12 column" id="botaoTema" >Upload Arquivo</a>
        <div class="panel">
            <p><small>Especificações do arquivo</small></p>
        </div>
    </div>
</div>
