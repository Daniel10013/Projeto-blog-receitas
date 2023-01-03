//função para verificar se as senhas estão corretas

function testa_senha()
{
    var senha1 = document.getElementById("pwd1").value;

    var senha2 = document.getElementById("pwd2").value;

    if(senha1 == senha2)
    {
        document.getElementById("err_msg").innerHTML = "";
        document.getElementById("btn_cadastro").disabled = false;
    }
    else
    {
        document.getElementById("err_msg").innerHTML = "As senhas não correspondem";
        document.getElementById("btn_cadastro").disabled = true;
    }
    

}

//função para verificar se os campos não estão vazios
function nao_vazio()
{
    var user = document.getElementById("username").value;
    var email = document.getElementById("email_cadastro").value;
    var senha1 = document.getElementById("pwd1").value;
    var senha2 = document.getElementById("pwd2").value;

    if(user === ""|| email === ""|| senha1 === ""|| senha2 === "")
    {
        document.getElementById("err_msg").innerHTML = "Não deixe os campos vazios!";
        document.getElementById("btn_cadastro").disabled = true;
    }
    else
    {
        document.getElementById("err_msg").innerHTML = "";
        document.getElementById("btn_cadastro").disabled = false; 
    }
}

function login_vazio()
{
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;

    if(email === ""|| senha === "")
    {
        document.getElementById("err_msg").innerHTML = "Não deixe os campos vazios!";
        document.getElementById("btn_login").disabled = true;
    }
    else
    {
        document.getElementById("err_msg").innerHTML = "";
        document.getElementById("btn_login").disabled = false; 
    }
}

function login()
{
    document.getElementById("err_msg").innerHTML = "Login ou senha incorretos!";
}

function email_indisponivel()
{
    var span = document.getElementById("err_msg");
    span.innerHTML = "Já existe uma conta registrada com esse email!";
    span.style.fontSize = "1vw";
}

//desativa o botão de comentarios caso o campo esteja vazio
function coment()
{
    var input = document.getElementById("comentIn").value;

    if(input === "")
    {
        document.getElementById("msg").innerHTML = "Não deixe o campo vazio";
        document.getElementById("sendC").disabled = true;
    }
}

//ativa novamente o botão ao digitar alguma coisa
function ativa()
{
    document.getElementById("sendC").disabled = false;
}

//função para visualizar a imagem
let img = document.getElementById("prfl_img");
let file = document.getElementById("file");

file.addEventListener('change', (event) =>{

    let reader = new FileReader();

    reader.onload = () =>{
        img.src = reader.result;
    }

    reader.readAsDataURL(file.files[0]);

})

function SenhaVazia()
{
    document.getElementById("msg").innerHTML = "Não deixe a senha vazia";
}