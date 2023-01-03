<?php

class funcoes
{
    //função para conseguir o nome da foto separadamente 
    public function Nome_arquivo($string)
    {
        //inverte a barra na string
        $str = str_replace("\\", "/", $string);
        $new_str = $str;

        //converte a string em array usando a barra como separador
        $ex = explode("/",$new_str);

        //variavel para obter a posição do ultimo item do array acima
        $a_p = 0;
        //percorre o array e obtem sua ultima posição
        foreach($ex as $ex1)
        {
            $a_p++;
        }

        //remove a ultima posição do array
        $pop = array_pop($ex);

        //transforma o array em string denovo
        $new = implode("/", $ex);

        return array($new, $pop);
    }  

    //função para copiar o arquivo para outro local
    public function CopiaArquivo($local, $nomeArquivo)
    {
        $new_local = "{$local}/{$nomeArquivo}";
        $copy_path = "img/receita_img/{$nomeArquivo}";
        return copy($new_local, $copy_path);
    }

    //a mesma coisa que a de cima para o perfil
    public function CopiaPerfil($local, $nomeArquivo)
    {
        $new_local = "{$local}/{$nomeArquivo}";
        $copy_path = "img/perfil_foto/{$nomeArquivo}";
        return copy($new_local, $copy_path);
    }

    //Função responsavel por imprimir corretamente o modo de preparo e os ingredientes
    public function Imprime_lista($lista)
    {
        $ex = explode("; ", $lista);
        return $ex;
    }

    //função para imagem
    public function ImagemSub($arquivo, $Oldfoto)
    {
        //verifica se o tipo do arquivo é o correto
        if(($arquivo["type"] == "image/jpeg" || $arquivo["type"] == "image/png" || ($arquivo["type"] == "image/gif")))
        {
            //copia a foto selecionada para a pasta no sistema onde são salvas as fotos do usuário
            move_uploaded_file($arquivo['tmp_name'],"img/perfil_foto/{$arquivo["name"]}");
            
            //verifica se a foto existe antes de apagar
            if(file_exists("img/perfil_foto/{$Oldfoto}"))
            {
                //apaga a foto anterior do usuário
                unlink("img/perfil_foto/{$Oldfoto}");
                $Nfoto = "C:/wamp64/www/web/img/perfil_foto/{$arquivo["name"]}";
                
                return $Nfoto;
            }
        }
        else
        {
            return '1';
        }
    }

    public function Lista($array)
    {
        foreach ($array as $larray)
        {
            echo"<li class='lii'><h3>{$larray}</h3></li>";
        }
    }
}

?>