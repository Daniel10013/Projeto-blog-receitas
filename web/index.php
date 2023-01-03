<?php
header("Content-type:text/html; charset=utf8");

//starts the session
session_start();

//importa a classe de usuarios
require_once "classes/Usuarios.php";
//importa a classe de posts
require_once "classes/Posts.php";
//importa a classe com outras funções
require_once "classes/Funcoes.php";

//cria uma instancia da classe de usuarios
$ins_users = new Usuarios();
//cria uma instancia da classe de posts
$ins_posts = new Posts();
//cria uma instancia da classe de funções
$ins_func = new Funcoes();


if(!isset($_SESSION["user_mail"]) || empty($_SESSION["user_mail"]))
{
    $atsec = "";
}
else
{
    $atsec = $_SESSION["user_mail"];
    //pega o id do usuario
    $id = $ins_users->Get_ID($atsec);    
    $_SESSION["user_id"] = $id[0]->ID;
    //pega a foto 
    $img = $ins_users->Foto_perfil($atsec);
    $pp = $img[0]->FOTO;

    //pega a foto de perfil
    $pic = $ins_users->Foto_perfil($_SESSION["user_mail"]);
    $np = $ins_func->Nome_arquivo($pic[0]->FOTO);
    $mp = $ins_func->CopiaPerfil($np[0], $np[1]);
    $proP = $np[1];


    //pega os dados das receitas
    $receita = $ins_posts->Descricao();

    //copia as receitas para outra pasta
    foreach ($receita as $receitas)
    {
        $path = $ins_func->Nome_arquivo($receitas->IMAGEM);
        $move = $ins_func->CopiaArquivo($path[0], $path[1]);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="img/chef.ico" type="image/x-icon">
    <title> Taste blog </title>
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
                                        <img id="pp" src="img/perfil_foto/<?php echo $proP; ?>">
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

        <!-- SCROLL CURVO -->
        <section>
            <span class="curve">
                <img src="img/curve.png">
            </span>
        </section>

        <!-- SCRIPT DO SCROLL CURVO -->
        <script type="text/javascript"> 
            var scroll = document.querySelector('.curve');
            window.addEventListener('scroll', function()
            {
                var value = 1 + window. scrollY/-500;
                scroll.style.transform = `scaleY(${value})`;
            }) 
        </script>

        <div class="title-receitas">
            <h1> Receitas mais famosas</h1>
        </div>
            
            <div class="container">
                <?php
                    //pega novamente os dados
                    $nreceita = $ins_posts->Descricao();
                    foreach ($nreceita as $conteudo)
                    {
                        $pimg = $ins_func->Nome_arquivo($conteudo->IMAGEM);
                ?>
                        <a class="card" href="receita.php?id=<?php echo $conteudo->ID;?>">
                            <span></span>
                            <div class="imgBx"><img src="img/receita_img/<?php echo $pimg[1]?>"></div>
                            <div class="content">
                                <div>
                                    <h2><?php echo $conteudo->TITULO;?></h2>
                                    <p><?php echo $conteudo->DESCRICAO;?></p>
                                </div>
                            </div>
                        </a>
                <?php
                    }
                ?>
            </div>

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
  </body>
</html>