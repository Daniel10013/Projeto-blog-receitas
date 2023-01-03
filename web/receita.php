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
    $postId = $_GET["id"];

    //verifica se existe um post com o id
    $ver = $ins_posts->Verifica($postId);
    //caso exista, carrega as informações do post
    if($ver == '0')
    {        
        //pega as informações do post caso nenhum erro aconteça ao passar o id
        $post = $ins_posts->PostTudo($postId);

        $post_img = $ins_func->Nome_arquivo($post[0]->IMAGEM);
        $foto = $post_img[1];

        $list = $ins_func->Imprime_lista($post[0]->INGREDIENTES);
        $mList = $ins_func->Imprime_lista($post[0]->CONTEUDO);
        
        $cmntimg = $ins_coment->SelectComent($postId);
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
    $vs = false;   
    $userId = "-3";
    $tipo_conta = "";
}
else
{
    $vs = true;
    $userId = $_SESSION["user_id"];
    //pega a foto de perfil
    $pic = $ins_users->Foto_perfil($_SESSION["user_mail"]);    
    $np = $ins_func->Nome_arquivo($pic[0]->FOTO);
    $mp = $ins_func->CopiaPerfil($np[0], $np[1]);
    $proP = $np[1];
    $tipo = $ins_users->Tipo_conta($userId);
    $tipo_conta = $tipo[0]->TIPO_CONTA;
}

if(isset($_POST["sendc"]))
{
    //verifica se o usuário está logado
    if($vs == false)
    {
        header("location:login.php");
    }
    //deixa o usuário postar o comentário caso o login exista
    else
    {
        //verifica se o campo do comentáio não está vazio
        if(!empty($_POST["cont"]))
        {
            
            header("location: receita.php?id={$postId}");
            //envia o comentário pro banco
            $inserir = $ins_coment->InserirComentario($postId, $userId);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="img/chef.ico" type="image/x-icon">
        <link rel="stylesheet" href="css/receita.css">
        <!-- O titulo da pagina é definido baseado no titulo do banco -->
        <title><?php echo $post[0]->TITULO;?></title>  
    </head>
    <body>
    <header>
            <!-- BARRA DE NAVEGÇÃO -->
                <nav>
                    <!-- LOGO DO SITE -->
                    <a  class="nava logo" href="index.php"> TASTE </a>
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
                                <li><a class="nava" href="login.php">Login</a></li>
                                <li><a class="nava" href="cadastro.php">Registe-se</a></li>
                            </ul>
                    <?php        
                        }
                        else
                        {
                    ?>
                        <ul class="btn_list nav-list">
                                <li>
                                    <a class="nava" href="perfil.php?id=<?php echo$_SESSION["user_id"];?>">
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
        <section>
            <div>
                <!-- titulo da receita -->
                <h1 id="titulo"><?php echo $post[0]->TITULO;?></h1>
                <!-- imagem da receita -->
                <img id="img_receita"src="img/receita_img/<?php echo $foto;?>">
                <!-- ingredientes -->
                    <div id="tb">
                        <h2 id="ingrediente">Ingredientes</h2>
                        <!-- form com o botao -->
                        <form action="" method="post">
                            <!-- confere se o post já está favoritado -->
                            <?php
                                $conf = $ins_favs->Confere_favorito($postId, $userId); 
                                if($conf == '1')
                                {
                                    $favorite = false;
                            ?>
                                    <button id="nfav" name="fav"></button>
                            <?php
                                }
                                //caso a receita esteja favoritada retorna o botão diferente
                                else
                                {
                                    $favorite = true;
                            ?>          
                                    <button id="afav" name="fav"></button>
                            <?php
                                }
                            ?>
                            <?php
                                //aciona caso o botão seja clicado
                                if(isset($_POST["fav"]))
                                {
                                    //manda o usuário para a página de login caso ele não esteja logado
                                    if($vs == false)
                                    {
                                        header("location:login.php");
                                    }
                                    else
                                    {
                                        //adiciona a receita aos favoritos caso ela não esteja favoritada
                                        if($favorite == false)
                                        {   
                                            $add = $ins_favs->AdicionaFavorito(intval($postId), intval($_SESSION["user_id"]));
                                            header('Refresh:0');
                                        }
                                        //remove a receita dos favoritos caso ela já esteja favoritada
                                        else
                                        {
                                            $remove = $ins_favs->RemoveFavorito(intval($postId), intval($_SESSION["user_id"]));
                                            header('Refresh:0');
                                        }
                                    }
                                }
                            ?>
                        </form>
                    </div>
                <div id="divilista">
                    <?php
                    //imprime as listas com os ingredientes e o modo de preparo
                    //as listas são imprimidas dessa forma para evitar de dar erro
                        echo"<ul id='ilista'>";
                        foreach($list as $lista)
                            {
                                echo"<li class='lii'><h3>$lista</h3></li>";
                            }
                        echo"</ul>";
                    ?>
                        
                    <h2 id="modo">Modo de preparo</h2>
                    <ol id="olista">  
                        <?php
                            $ins_func->Lista($mList);
                        ?>
                    </ol>
                </div>
                <fieldset>            
                    <form method="post">
                        <textarea type="text" name="cont" id="comentIn" oninput="ativa()" placeholder="Insira seu comentário"></textarea>
                        <button name="sendc" id="sendC" onclick="coment()" type="submit">Enviar comentário</button>
                        <span id="msg"></span>
                        <?php
                        ?>
                    </form>
                </fieldset>

                <?php       
                    //pega as informações dos comentários
                    $coment = $ins_coment->SelectComent($postId);
                    //se diferente de 1, existem comentários
                    if($coment != '1')
                    {
                        //imprime os comentários
                        foreach($coment as $comentario)
                        {
                            //funções responsaveis por pegaram a foto de perfil do usuário
                            $id = intval($comentario->USER_ID);
                            $perfil = $ins_users->Foto_perfilID($id);
                            $img_src = $perfil[0]->FOTO;
                            $arq = $ins_func->Nome_arquivo($img_src);
                            $foto = $arq[1];

                            //nome de usuário
                            $un = $ins_users->Username($id);
                            // var_dump(); die();

                ?>          
                            <br>
                            <div id="div_comment">
                                <div id="div_profile">
                                    <img id="prflimg"src="img/perfil_foto/<?php echo $foto;?>">
                                    <p><?php echo $un[0]->USERNAME?></p>
                                </div>
                                <p></p>
                                <p id="cmnt_text"><?php echo $comentario->CONTEUDO;?></p>
                                <p></p>
                                <?php
                                    if($tipo_conta == "administrador" || $userId == $comentario->USER_ID)
                                    {
                                ?>
                                        <a name="apagar" id="deletecoment" href="delete.php?codigo=<?php echo $comentario->CODIGO;?>&id=<?php echo $postId;?>">Apagar comentário</a>
                                <?php
                                    }
                                ?>
                            </div>
                <?php
                        }
                    }
                    //se = 1, não existem
                    else
                    {
                ?>      
                        <br>
                        <div id="noComment">
                            <p>Não existem comentários nesse post ainda!</p>
                            <p>Seja o primeiro a comentar!</p>
                        </div>
                <?php
                    }

                ?>
            </div>
        </section>
    </body>
    <script src="js/outro.js"></script>
</html>