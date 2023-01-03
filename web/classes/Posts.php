<?php
//importar a classe de conexo
require_once "classes/ConexaoBD.php";

class posts
{
    //atributos da tabela
    public $ID;
    public $TITULO;
    public $DESCRICAO;
    public $CONTEUDO;
    public $IMAGEM; 

    //Metodos (CRUD -> INSERT / DELETE / UPDATE)
    public function Descricao()
    {
        try
        {
            //classe de conexão
            $bd = new conexaoBD();
            //variavel que executa o comando sql
            $sql = ("select DESCRICAO, TITULO, IMAGEM, ID from POSTS");
            //retorna o resultado do select
            return $bd->execute_Select($sql);
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel obter os dados da receita". $msg ->getMessage();
        }
    }

    //pega todas as informações do post
    public function PostTudo($id)
    {
        $this->ID = $id;

        //classe de conexão
        $bd = new conexaoBD();
        //variavel que executa o comando sql
        $sql = ("select * from POSTS where ID = '{$this->ID}'");
        //retorna o resultado do select
        return $bd->execute_Select($sql);
    }

    //verifica se a receita existe
    public function Verifica($id)
    {
        $this->ID = $id;

        //classe de conexão
        $bd = new conexaoBD();
        //variavel que executa o comando sql
        $sql = ("select * from POSTS where ID = '{$this->ID}'");
        //retorna o resultado do select
        $ver = $bd->execute_Select($sql);

        //baseado na quantidade de itens retornada pelo banco
        //verifica a existencia de uma receita com aquele ID
        if(count($ver) >= 3)
        {
            return '1';
        }
        else
        {
            return '0';
        }
    }

    //busca receita
    public function BuscaReceita($titulo)
    {
        $this->TITULO = $titulo;
        //classe de conexão
        $bd = new conexaoBD();
        //variavel que executa o comando sql
        $sql = ("select * from POSTS where TITULO = '{$this->TITULO}'");
        //retorna o resultado do select
        $ver = $bd->execute_Select($sql);

        if(count($ver) >= 3)
        {
            return '1';
        }
        else
        {
            return $ver;
        }
    }
}

?>