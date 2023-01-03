<?php

//importa a classe de posts
require_once "classes/Posts.php";
$ins_posts = new Posts();
//importa a classe dos comentários
require_once "classes/Comentarios.php";
$ins_coment = new Comentarios();
//importa a classe de favoritos
require_once "classes/Favoritos.php";
$ins_favs = new Favoritos();

if(isset($_GET["id"]) && !empty($_GET["id"]))
{
    //verifica se existe um post com o id
    $postId = $_GET["id"];
    $ver = $ins_posts->Verifica($postId);
    //caso exista, apaga o comentário
    if($ver == '0')
    {
        if(isset($_GET["codigo"]))        
        {
            $del = $ins_coment->ApagaComentario($_GET["codigo"]);
        }
        header("location: receita.php?id={$postId}");
    }
    else
    {
        header("location: index.php");
    }
}
elseif(isset($_GET["favid"]) && !empty($_GET["favid"]) && isset($_GET["uid"]) && !empty($_GET["uid"]))
{
    $favId = $_GET["favid"];
    $del = $ins_favs->RemoveFavoritoID($favId);
    header("location: perfil.php?id={$_GET["uid"]}");
}
else
{
    header("location: index.php");
}

?>