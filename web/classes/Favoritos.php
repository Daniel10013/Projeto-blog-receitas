<?php
//importar a classe de conexo
require_once "classes/ConexaoBD.php";

class favoritos
{
    public $CODIGO;
    public $POST_ID;
    public $USER_ID;

    public function Confere_favorito($postId, $userID)
    {
        try
        {
            //preenche os campos
            $this->POST_ID = $postId;
            $this->USER_ID = $userID;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select * from FAVORITOS where POST_ID = '{$this->POST_ID}' and USER_ID = '{$this->USER_ID}';";

            $ver = $bd->execute_Select($sql);
            if(count($ver) != 1)
            {
                return '1';
            }
            else
            {
                return '0';
            }
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel conferir os campos". $msg ->getMessage();
        }
    }

    public function AdicionaFavorito($postId, $userID)
    {        
        try 
        {
            //preenche os campos
            $this->POST_ID = $postId;
            $this->USER_ID = $userID;
            
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "INSERT into FAVORITOS (CODIGO, POST_ID, USER_ID) values
            (null, '{$this->POST_ID}', '{$this->USER_ID}');";

            return($bd->execute_Query($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel adicionar aos favoritos". $msg ->getMessage();
        }
    }

    public function RemoveFavorito($postId, $userID)
    {
        try
        {
            //preenche os campos
            $this->POST_ID = $postId;
            $this->USER_ID = $userID;
            
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "delete from FAVORITOS where POST_ID = '{$this->POST_ID}' and USER_ID = '{$this->USER_ID}';";

            return($bd->execute_Query($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel remover dos favoritos". $msg ->getMessage();
        }
    }

    //FUNÇÃO PARA PUXAR OS FAVORITOS DO USUÁRIO
    public function UserFavoritos($userID)
    {
        try
        {
            //preenche os campos
            $this->USER_ID = $userID;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select * from FAVORITOS where USER_ID = '{$this->USER_ID}';";

            $ver = $bd->execute_Select($sql);
            
            if($ver[0] === '00000')
            {
                return '0';
            }
            //não tem favoritos salvos
            else
            {
                return $ver;
            }
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel conferir os favoritos". $msg ->getMessage();
        }
    }

    //função para deletar um favorito com o ID especifico
    public function RemoveFavoritoID($favid)
    {
        try
        {
            //preenche os campos
            $this->CODIGO = $favid;
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "DELETE from FAVORITOS where CODIGO = '{$this->CODIGO}';";

            return $bd->execute_Query($sql);
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel remover o favorito". $msg ->getMessage();
        }
    }
}
?>