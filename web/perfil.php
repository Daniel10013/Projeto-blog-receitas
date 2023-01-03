<?php
header("Content-type:text/html; charset=utf8");

//starts the session
session_start();

//importa a classe de usuarios
require_once "classes/Usuarios.php";
//importa a classe de posts
require_once "classes/Posts.php";
//importa a classe de favoritos
require_once "classes/Favoritos.php";
//importa a classe dos comentários
require_once "classes/Comentarios.php";
//importa a classe com outras funções
require_once "classes/Funcoes.php";

/* CRIA INSTANCIAS DAS CLASSES DE FUNCOES */
$ins_users = new Usuarios();
$ins_posts = new Posts();
$ins_favs = new Favoritos();
$ins_coment = new Comentarios();
$ins_func = new Funcoes();
/* *************************************** */


//verifica se o id foi passado corretamente
if(isset($_GET["id"]) && !empty($_GET["id"]))
{
    $Id = $_GET["id"];

    //verifica se existe um usuario com o id
    $ver = $ins_users->VerificaID(intval($Id));
    // var_dump($ver); die();
    //caso exista, carrega as informações do usuário
    if($ver == '0')
    {     
        $user = $ins_users->SelectUser($Id);

        $ft = $ins_func->Nome_arquivo($user[0]->FOTO);
        $cp = $ins_func->CopiaPerfil($ft[0], $ft[1]);
    
        $foto = $ft[1];
    
        $postId = $_GET["id"];   

        $favs = $ins_favs->UserFavoritos($Id);
        //indica que o usuário não tem favoritos salvos
        if($favs == '0')
        {
            $nfav = true;
        }
        else
        {
            $nfav = false;
        }

    }
    //se não existir redireciona o usuário para outra página
    else
    {
        header("location: index.php");
    }
}

//verifica se o usuario está logado
if(empty($_SESSION["user_id"]))
{
    header("location: index.php");
}
else
{
    $vs = true;
    $userId = $_SESSION["user_id"];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="img/chef.ico" type="image/x-icon">
        <link rel="stylesheet" href="css/perfil.css">
        <title><?php echo $user[0]->USERNAME;?></title>
    </head>
    <body>
    <header>
            <!-- BARRA DE NAVEGÇÃO -->
                <nav>
                    <!-- LOGO DO SITE -->
                    <a class="logo" href="index.php"> TASTE </a>
                    <!-- SEARCH BOX -->
                    <div class="search-box"> 
                        <form method="post">
                            <input class="search-txt" type="text" name="busca" placeholder="Buscar uma receita">
                            <button class="search-btn"? name="pesquisar"></button>
                            <?php
                                if(isset($_POST["pesquisar"]))
                                {
                                    header("location:busca.php?receita={$_POST['busca']}");
                                }
                            ?>
                        </form>
                    </div>
                    <!-- PARTE RESPONSIVA DA BARRA DE NAVEGAÇÃO -->
                    <div class="mobile-menu">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                    </div>

                    <!-- imprime os links para login e cadastro  -->
                    <?php
                        if(!isset($_SESSION["user_mail"]))
                        {
                    ?>  
                            <!-- LINKS -->
                            <ul class="nav-list">
                                <li><a href="login.php">Login</a></li>
                                <li><a href="cadastro.php">Registe-se</a></li>
                            </ul>
                    <?php        
                        }
                        else
                        {
                    ?>
                        <ul class="btn_list nav-list">
                                <li>
                                    <a href="perfil.php?id=<?php echo$_SESSION["user_id"];?>">
                                        <img id="pp" src="img/perfil_foto/<?php echo $foto; ?>">
                                    </a>
                                </li>
                                <form id="btn_form" action="" method = "post">
                                    <button id="btn_logout"type="submit" name="logout"><img src="img/logout.png"></button>
                                    <?php
                                        if(isset($_POST["logout"]))
                                        {
                                            session_destroy();
                                            session_start();
                                            header('Refresh:0');
                                        }
                                    ?>
                                </form>
                        </ul>
                    <?php    
                        }
                    ?>     
            </nav>
        </header>
        <section id="psec">          
            <div id="userbox">
                <div id="sub_box">
                    <img id="prfl_img" src="img/perfil_foto/<?php echo $foto?>" alt="">
                    <h1 id="username"><?php echo $user[0]->USERNAME;?></h1>
                </div>
                <a href="editar.php?id=<?php echo $Id?>">Editar perfil</a>
            </div>
            <div id="favorite_box">
                <h1>Receitas favoritas</h1>
                <?php
                    //carrega os favoritos caso eles existam
                    if($nfav == false)
                    {
                        foreach($favs as $favoritos)
                        {
                            $imgFt = $ins_posts->PostTudo(intval($favoritos->POST_ID));
                            $strImg = $imgFt[0]->IMAGEM;
                            $strFormat = $ins_func->Nome_arquivo($strImg);
                            $imgMove = $ins_func->CopiaArquivo($strFormat[0], $strFormat[1]);
                            $imgNome = $strFormat[1];
                ?>
                            <div id="print_fav">
                                <a href="receita.php?id=<?php echo $favoritos->POST_ID?>"><img id="fav_img" src="img/receita_img/<?php echo $imgNome?>"></a>
                                <a href="delete.php?favid=<?php echo$favoritos->CODIGO;?>&uid=<?php echo$favoritos->USER_ID?>" id="rmvfav" >Remover dos favoritos</a>
                            </div>
                <?php
                        }
                    }
                    //diz que o usuário não tem favoritos
                    else
                    {
                ?>
                        <h1>Você não tem favoritos</h1>
                <?php
                    }
                ?>
            </div>
        </section>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('.card').on('mouseenter', function(e){
                    x = e.pageX - $(this).offset().left,
                    y = e.pageY - $(this).offset().top,
                    $(this).find('span').css({top:y, left:x})
                })
                
                $('.card').on('mouseout', function(e){
                    x = e.pageX - $(this).offset().left,
                    y = e.pageY - $(this).offset().top,
                    $(this).find('span').css({top:y, left:x})
                })
            })
        </script>
        <!-- SCRIPT PARA DEIXAR RESPONSIVO PARA O CELULAR -->
        <script src="js/mobile-navbar.js"></script>
</html>