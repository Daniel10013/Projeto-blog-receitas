<?php
header("Content-type:text/html; charset=utf8");

//starts the session
session_start();

//importa a classe de usuarios
require_once "classes/Usuarios.php";

//cria uma instancia da classe de usuarios
$ins_users = new Usuarios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/chef.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body class="sign-in-js">
<script src="js/outro.js"></script>
    <div class="container">    
    
        <!-- *************************************************************************************************** -->
                                                <!-- PARTE DO LOGIN -->
        <!-- *************************************************************************************************** -->

        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">Seja Bem vindo!</h2>
                <p class="description description-primary">Não possui um conta?</p>
                    <p class="description description-primary">Faça uma agora!</p>
                <button onclick="window.location.href='cadastro.php'" id="signup" class="btn btn-primary">Registrar</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second">Entre em sua conta</h2>
               
                <p class="description description-second">insira seu email e sua senha:</p>
                <!-- forms de login -->
                <form action="" method="post" class="form">    
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" id="email" name="email" placeholder="Email">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" id="senha" name="senha" placeholder="Senha">
                    </label>
                    
                    <a class="password" href="login.php">esqueceu sua senha?</a>
                    <button type="submit" name="login" id="btn_login"onclick="login_vazio()" class="btn btn-second">Entrar</button>
                    <span id="err_msg"></span>
                </form>
            </div>
            <?php
                //acontece quando clicar no botão login
                if(isset($_POST["login"]))
                {
                    if(!empty($_POST["senha"]) && !empty($_POST["email"]))
                    {
                        $result = $ins_users->Login();
                        //echo count($result);
                        //var_dump($result); die(); 
                        //testa se o login deu certo
                        if($result != 0)
                        {   
                            $email = $_POST["email"];
                            $_SESSION["user_mail"] = $email;
                            header('location:index.php');
                        }
                        //login deu errado 
                        else
                        {
                            echo'<script>login()</script>';
                        }
                    }
                }
            ?>

        </div>
    </div>
</body>
</html>