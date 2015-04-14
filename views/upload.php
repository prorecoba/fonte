<?php
include_once "./controllers/uploadController.php";
?>

<?php
if(isset($viewOA)){
    $totalFrgt = $viewOA["totalFragmentos"];
    $totalFrgtAprov = $viewOA["totalFragmentosAproveitados"];
    $porcentagemAprov = number_format(($totalFrgtAprov*100)/$totalFrgt,2,'.','');
    echo "<script type='text/javascript'>alert('Arquivo carregado com sucesso! Foi calculado $porcentagemAprov% de aproveitamento no Objeto de Aprendizagem.')</script>";
    header("refresh: 0; ./file&id=$idPub");
}
?>

<div class="row">
    <div class="large-12 column">
        <ul class="breadcrumbs">
            <li><a href="./home">Início</a></li>
            <li class="current"><a href="">Upload</a></li>
        </ul>
    </div>
    <div class="large-6 column">
        <form name="upload" id="upload" method="post" action="<?php echo "./".VIEW ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="large-12 column">
                    <input type="text" name="autor" required placeholder="Autor" />
                </div>
                <div class="large-12 column">
                    <input type="text" name="title" required placeholder="Titulo do arquivo" />
                </div>
                <div class="large-12 column">
                    <input type="text" name="description" required placeholder="Descrição do arquivo" />
                </div>
                <div class="large-12 column">
                    <input type="text" name="language" required placeholder="Idioma" />
                </div>
                <div class="large-12 column">
                    <input type="text" name="keywords" required placeholder="Palavras chaves" />
                </div>
                <div class="large-12 column">
                    <input type="file" required name="file"  />
                </div>
                <div class="large-12 column">
                    <input  type="submit" id="botaoTema" class="button [tiny small ]"  value="Upload" />
                </div>
            </div>
        </form>
    </div>
    <div class="large-6 column">
        <div class="panel">
            <p class="text-justify">

                    Neste projeto será aceito apenas o formato OpenDocument (ou OpenDocument Format ? ODF).
                    Como aqui trabalharemos com objetos do tipo Publicação, usaremos a extensão .ODT. Extensão esta para documentos de texto.
                    Para um melhor resultado, formate-o usando estilo.

            </p>
        </div>
    </div>
</div>
