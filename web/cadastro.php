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
    <title>Cadastro</title>
</head>
<body> 
    <script src="js/outro.js"></script>
    <div class="container">
        
        <!-- *************************************************************************************************** -->
                                                <!-- PARTE DO CADASTRO -->
        <!-- *************************************************************************************************** -->
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">Bem vindo de volta!</h2>
                <p class="description description-primary">Já possui uma conta?</p>
                <p class="description description-primary">Faça seu login</p>
                <button onclick="window.location.href='login.php'" id="signin" class="btn btn-primary">Entrar</button>
            </div>    
            <div class="second-column">
                <h2 class="title title-second">Crie uma conta</h2>
            
                <p class="description description-second">inserindo seus dados pessoais</p>
                <!-- Forms de cadastro -->
                <form class="form" action="" method="post">
                    <label class="label-input" for="">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" name="username" id="username" placeholder="Nome de usuário">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" name="registro_email" id="email_cadastro"placeholder="Email">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input id="pwd1"type="password" name="registro_senha" oninput="testa_senha()" placeholder="Senha">
                    </label>

                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input id="pwd2" type="password" name="confirma_senha" oninput="testa_senha()" placeholder="Confirme sua senha">
                    </label>
                    
                    <span id="err_msg"></span>
                     
                    <button id="btn_cadastro" type="submit" name="registrar" onclick="nao_vazio()"class="btn btn-second">Registrar</button>        
                    
                    <?php
                    
                        //acontece quando clicar no botão de criar conta
                        if(isset($_POST["registrar"]))
                        {   
                            $cadastro = $ins_users->ver_email();
                            //email não está disponivel
                            if($cadastro == 1)
                            {
                                //cria a conta se o email estiver livre
                                $registro = $ins_users->Cadastro();
                                
                                $email = $_POST["registro_email"];
                                $_SESSION["user_mail"] = $email;
                                header('location:index.php');
                            }
                            else
                            {
                                echo'<script>email_indisponivel();</script>';
                            }
                        } 
                    ?>
                </form>
            </div>
        </div>

        <!-- *************************************************************************************************** -->
                                                <!-- PARTE DO LOGIN -->
        <!-- *************************************************************************************************** -->

        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">Seja Bem vindo!</h2>
                <p class="description description-primary">Não possui um conta?</p>
                <p class="description description-primary">Faça uma agora!</p>
                <button id="signup" class="btn btn-primary">Registrar</button>
            </div>
        </div>
    </div>
</body>
</html>