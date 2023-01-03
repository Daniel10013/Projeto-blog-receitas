<?php
//importar a classe de conexo
require_once "classes/ConexaoBD.php";

class comentarios
{
    public $CODIGO;
    public $CONTEUDO;
    public $POST_ID;
    public $USER_ID;    

    //faz o select de todos os comentários do post
    public function SelectComent($postID)
    {
        try
        {
            $this->POST_ID = $postID;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "SELECT * from COMENTARIOS where POST_ID = '{$this->POST_ID}';";

            $a = $bd->execute_Select($sql);
            if($a[0] == '00000')
            {
                return '1'; 
            }
            else
            {
                return $a;
            }
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel verificar os comentários". $msg ->getMessage();
        }
    } 

    public function InserirComentario($postID, $userID)
    {
        try
        {
            $this->USER_ID = $userID;
            $this->POST_ID = $postID;
            $this->CONTEUDO = $_POST["cont"];

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "INSERT INTO COMENTARIOS VALUES(NULL, '{$this->CONTEUDO}', '{$this->POST_ID}', '{$this->USER_ID}');";

            return ($bd->execute_Query($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel verificar os comentários". $msg ->getMessage();
        }
    }

    public function ApagaComentario($comntId)
    {
        $this->CODIGO = $comntId;

        //instancia da classe de conexão
        $bd = new conexaoBD();
        //comando sql
        $sql = "DELETE FROM COMENTARIOS WHERE CODIGO ='{$this->CODIGO}';";
        
        return ($bd->execute_Query($sql));
    }
}

?>