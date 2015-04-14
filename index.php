
<?php
    include_once "system/queryString.php";
    $get = isset($_GET["get"]) ? $_GET["get"] : "home";

    #region CONSTANTS
    define("VIEW", $get);
    define("PATHAPP",getcwd());
    #endregion
?>


<html >
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recoba</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/vendor/modernizr.js"></script>
</head>
<body>
    <div id="top">
        <div class="row" >
            <div class="large-8 column">
                <h2 style="color: #FFFFFF">
                    <img src="images/RecobaFinal_Cor.png" class="left" width="250" style="margin: 10px 0;" />
                </h2>
            </div>
            <div class="large-4 column" style="margin-top: 12px">
                <form name="formPesquisa" id="formPesquisa" method="post" action="./search" >
                    <div class="row collapse ">
                        <div class="large-9 columns">
                            <input type="text" name="str" placeholder="Pesquisar"  />
                        </div>
                        <div class="large-3 columns">
                            <input  type="submit" id="botaoPesquisa" class="button postfix" value="Buscar" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="menu">
        <div class="row">
            <div class="large-12 column">
                <ul class="sub-nav">
                    <li><a href="./home" >Início</a></li>
                    <li><a href="./listfiles" >Objetos de Aprendizagem</a></li>
                    <li><a href="https://github.com/prorecoba/fonte" target="_blank" >Codigo Fonte</a></li>
                    <li><a href="./sobre">Sobre</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="content" >
        <?php queryString::getPage($get) ?>
    </div>


    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/foundation/foundation.accordion.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.paragraph > a.link-paragraph').click(function(e){
                if(e.target.className == 'link-paragraph'){
                    var id = e.target.hash;
                    $(".paragraph > .content-paragraph"+id+"").slideToggle(300);
                }
            });

            $('input:file[name="file"]').change(function() {
                var arq = this.files[0];
                var ext = arq.name.split('.')[1];
                if(ext == "odt" || ext == "ODT"){

                }else{
                    alert("A extensão do arquivo deve ser .ODT!. Tipo do arquivo: ");
                    $('input:file[name="file"]').val("");
                }
            });
        });

        $(document).foundation({
            accordion: {
                callback : function (accordion) {
                }
            }
        });
    </script>
</body>
</html>

