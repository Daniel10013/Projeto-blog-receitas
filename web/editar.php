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
    //caso exista, carrega as informações do usuário
    if($ver == '0')
    {     
        $user = $ins_users->SelectUser($Id);
        $ft = $ins_func->Nome_arquivo($user[0]->FOTO);
        $cp = $ins_func->CopiaPerfil($ft[0], $ft[1]);
        // var_dump($ft) ;die();
        $foto = $ft[1];
    
        $postId = $_GET["id"];   

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
        <link rel="stylesheet" href="css/editar.css">
        <title>Editar perfil</title>
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
        
        <section>
            <form id="edit" action="" method="post" enctype="multipart/form-data">
                <div id="edit1">   
                    <img id="prfl_img" src="img/perfil_foto/<?php echo $foto?>" alt="">
                    <label for="file">Escolher Foto
                    <input id="file" type="file" name="file">
                    </label>
                </div>

                <div id="edit2">
                    <label for="">
                        Nome de usuário:
                        <input class="in"type="text" name ="username" id="username" value="<?php echo $user[0]->USERNAME?>">
                    </label>
                    <label class="space" for="">
                        Email:
                        <input class="in" type="mail" name ="email" id="email" value="<?php echo $user[0]->EMAIL?>">
                    </label>
                    <label class="atsenha" for="">
                        <input  type="password" name="atpwd"placeholder="Insira a senha atual para salvar">
                    </label>
                    
                    <button id="btnsalvar"name="salvar"type="submit">Salvar Alterações</button>
            <?php
                    //acontece ao clicar no botão salvar
                    if(isset($_POST["salvar"]))
                    {
                        //verifica se o campo da senha foi preenchido
                        $pwd = $ins_users->VerificaSenha($Id);
                        if(empty($_POST["atpwd"]))
                        {
                ?>
                            <span class="msg">Não deixe a senha vazia</span>
                <?php
                        }
                        //deixa o usuario prosseguir se os campos estiverem preenchidos
                        else
                        {
                            //verifica se a senha digita é a senha correta
                            $verpwd = $ins_users->VerificaSenha($Id);
                            //prossegue a operação
                            if($_POST["atpwd"] == $verpwd[0]->SENHA)
                            {
                                //atualiza as informações
                                /*
                                * Atualiza as informações com base em dois parametros
                                * 1-Vê se o email foi modificado
                                * 2-Caso o email tenha sido modificado, verifica se o email selecionado está disponivel
                                * Se não estiver disponivel, avisa que não está, se estiver, troca o email 
                                */
                                //email não foi modificado
                                if($_POST["email"] == $user[0]->EMAIL)
                                {
                                    
                                    $arquivo = $_FILES['file'];
                                    //usuário não selecionou imagem
                                    if($arquivo["name"] == '')
                                    {
                                        //atualiza o perfil sem mudar a imagem
                                        $ufoto = $foto;
                                        $updateNM = $ins_users->UpdateNomail($Id, $ufoto);
                                        header("location:perfil.php?id={$Id}");
                                    }
                                    //selecionou imagem
                                    else
                                    {
                                        //pega a imagem do usuário
                                        $fFoto = $ins_func->ImagemSub($arquivo, $foto);
                                        if($fFoto == '1')
                                        {
            ?>
                                            <span class="msg">Formato de imagem incorreto</span>
            <?php
                                        }
                                        else
                                        {
                                            
                                            $updateNM = $ins_users->UpdateNomail($Id, $fFoto);
                                            header("location:perfil.php?id={$Id}");
                                        }
                                        
                                    }
                                }
                                //email foi modificado
                                else
                                {
                                    $vermail = $ins_users->ver_email_p($_POST["email"]);
                                    //email está livre
                                    if($vermail == 1)
                                    {
                                        $arquivo = $_FILES['file'];
                                        //usuário não selecionou imagem
                                        if($arquivo["name"] == '')
                                        {
                                            //atualiza o perfil sem mudar a imagem
                                            $ufoto = $foto;
                                            $updateWM = $ins_users->UpdateWmail($Id, $ufoto);
                                            header("location:perfil.php?id={$Id}");
                                        }
                                        //selecionou imagem
                                        else
                                        {
                                            //pega a imagem do usuário
                                            $fFoto = $ins_func->ImagemSub($arquivo, $foto);
                                            if($fFoto == '1')
                                            {
                ?>
                                                <span class="msg">Formato de imagem incorreto</span>
                <?php
                                            }
                                            else
                                            {
                                                
                                                $updateWM = $ins_users->UpdateWmail($Id, $fFoto);
                                                header("location:perfil.php?id={$Id}");
                                            }
                                        }
                                    }
                                    //email não disponivel
                                    else
                                    {
                ?>
                                        <span class="msg">O email selecionado não está disponivel</span>
                <?php                   
                                    }
                                }
                            }
                            //avisa que a senha inserida é a errada
                            else
                            {
                ?>
                                <span class="msg">Senha incorreta!</span>
                <?php
                            }
                        }
                    }
                ?>
                </div>
            </form>
        </section>
    </body>
    <script src="js/outro.js"></script>    
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