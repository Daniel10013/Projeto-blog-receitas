<?php
//importar a classe de conexo
require_once "classes/ConexaoBD.php";

class Usuarios
{
    //atributos da tabela
    public $ID;
    public $USERNAME;
    public $EMAIL;
    public $SENHA;
    public $TIPO_CONTA;
    public $FOTO;

    //Metodos (CRUD -> INSERT / DELETE / UPDATE)

    //metodo de login
    public function Login()
    {
        try
        {
            //preenche os campos de email e senha
            $this->EMAIL = $_POST["email"];
            $this->SENHA = $_POST["senha"];

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select * from USUARIOS where EMAIL = '{$this->EMAIL}' and SENHA = '{$this->SENHA}';";
            
            $select = $bd->execute_Select($sql);
            if(count($select) == 1)
            {
                return $select;
            }
            else
            {
                return 0;
            }
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel obter os dados para o login". $msg ->getMessage();
        }
    }
    //função para verificar se existe uma conta com aquele email
    public function ver_email()
    {
        try
        {
            //preenche os campos
            $this->EMAIL = $_POST["registro_email"];

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select EMAIL from USUARIOS where EMAIL = '{$this->EMAIL}'";
            $result = $bd->execute_Select($sql);    

            //já existe uma conta com o email
            if(count($result) == 1)
            {
                return 0;
            }   
            //email está livre
            else
            {
                return 1;
            }
        }   
        catch(PDOException $msg)
        {
            echo "Não foi possivel verificar a conta". $msg ->getMessage();
        }      
    }

    //vefifica se existe uma conta com aquele id
    public function VerificaID($id)
    {
        try
        {
            //preenche os campos
            $this->ID = $id;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select ID from USUARIOS where ID = '{$this->ID}'";
            $result = $bd->execute_Select($sql);    

            //não existe a conta
            if($result[0] == '00000')
            {
                return '1';
            }   
            //conta existe
            else
            {
                return '0';
            }
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel verificar o ID". $msg ->getMessage();
        } 
    }

        //vefifica se a senha está correta
        public function VerificaSenha($id)
        {
            try
            {
                //preenche os campos
                $this->ID = $id;
    
                //instancia da classe de conexão
                $bd = new conexaoBD();
                //comando sql
                $sql = "select SENHA from USUARIOS where ID = '{$this->ID}'";
                $result = $bd->execute_Select($sql);    
    
                return $result;
            }
            catch(PDOException $msg)
            {
                echo "Não foi possivel verificar a senha". $msg ->getMessage();
            } 
        }

    //seleciona todos os dados do usuário
    public function SelectUser($id)
    {
        try
        {
            //preenche os campos
            $this->ID = $id;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select * from USUARIOS where ID = '{$this->ID}'";
            $result = $bd->execute_Select($sql);    

            return $result;
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel obter os dados". $msg ->getMessage();
        }
    }

    //metodo de cadastro
    public function Cadastro()
    {
        try
        {
            //preenche os campos de email e senha
            $this->USERNAME = $_POST["username"];
            $this->EMAIL = $_POST["registro_email"];
            $this->SENHA = $_POST["registro_senha"];
            $this->TIPO_CONTA = "comum";
            $this->FOTO = "C:/wamp64/www/web/img/semfoto.png";

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "insert into USUARIOS values(NULL, '{$this->USERNAME}', '{$this->SENHA}', '{$this->EMAIL}', 
            '{$this->TIPO_CONTA}', '{$this->FOTO}')";
            
            return $bd->execute_Query($sql);
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel realizar o cadastro". $msg ->getMessage();
        }
    }

    //função que pega a foto de perfil do usuario ao logar
    public function Foto_perfil($email)
    {
        try
        {
            $this->EMAIL = $email;
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select FOTO from USUARIOS where EMAIL = '{$this->EMAIL}'";

            return($bd->execute_Select($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel pegar a foto". $msg ->getMessage();
        }
    }

    //função que pega o id do usuário
    public function Get_ID($email)
    {
        try
        {
            $this->EMAIL = $email;        
            
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select ID from USUARIOS where EMAIL = '{$this->EMAIL}'";
        
            return($bd->execute_Select($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel pegar o id". $msg ->getMessage();
        }
    }


    /*
    * ESSAS FUNÇÕES SÃO USADAS NA PÁGINA DAS RECEITAS
    */

    //pega o tipo da conta
    public function Tipo_conta($userID)
    {
        try
        {
            $this->ID = $userID;        
            
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select TIPO_CONTA from USUARIOS where ID = '{$this->ID}'";
        
            return($bd->execute_Select($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel pegar o tipo da conta". $msg ->getMessage();
        }
    }

    //mesma função porem com o ID
    public function Foto_perfilID($id)
    {
        try
        {
            $this->ID = $id;
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select FOTO from USUARIOS where ID = '{$this->ID}'";
    
            return($bd->execute_Select($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel pegar a foto". $msg ->getMessage();
        }
    }

    //função para pegar o username
    public function Username($id)
    {
        try
        {
            $this->ID = $id;
            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select USERNAME from USUARIOS where ID = '{$this->ID}'";
    
            return($bd->execute_Select($sql));
        }
        catch(PDOException $msg)
        {
            echo "Não foi possivel pegar o nome de usuário. $msg ->getMessage()";
        }
    }



    //função para verificar se existe uma conta com aquele email com um paremetro diferente
    public function ver_email_p($email)
    {
        try
        {
            //preenche os campos
            $this->EMAIL = $email;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "select EMAIL from USUARIOS where EMAIL = '{$this->EMAIL}'";
            $result = $bd->execute_Select($sql);    

            //já existe uma conta com o email
            if(count($result) == 1)
            {
                return 0;
            }   
            //email está livre
            else
            {
                return 1;
            }
        }   
        catch(PDOException $msg)
        {
            echo "Não foi possivel verificar a conta". $msg ->getMessage();
        }      
    }

    /***********************************************************************************/
    /* AS FUNÇÕES A SEGUIR SÃO PARA A ATUALIZAÇÃO DOS DADOS DO USUÁRIO */
    /* UMA DAS FUNÇÕES É PARA ATUALIZAR SEM MUDAR O EMAIL, E A OUTRA MUDANDO O EMAIL */
    /***********************************************************************************/
    //atualizar com email
    public function UpdateWmail($id, $foto)
    {
        try
        {
            //preenche os campos
            $this->ID = $id;
            $this->USERNAME = $_POST["username"];
            $this->EMAIL = $_POST["email"];
            $this->FOTO = $foto;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "UPDATE USUARIOS SET USERNAME = '{$this->USERNAME}', EMAIL = '{$this->EMAIL}', FOTO = '{$this->FOTO}' where ID = '{$this->ID}'";
            
            $var =  $bd->execute_Query($sql);

            return $var;
        }   
        catch(PDOException $msg)
        {
            echo "Não foi possivel atualizar os dados". $msg ->getMessage();
        }      
    }

    //atualizar sem o email
    public function UpdateNomail($id, $foto)
    {
        try
        {
            //preenche os campos
            $this->ID = $id;
            $this->USERNAME = $_POST["username"];
            $this->FOTO = $foto;

            //instancia da classe de conexão
            $bd = new conexaoBD();
            //comando sql
            $sql = "UPDATE USUARIOS SET USERNAME = '{$this->USERNAME}', FOTO = '{$this->FOTO}' where ID = '{$this->ID}'";
            
            $var =  $bd->execute_Query($sql);

            return $var;
        }   
        catch(PDOException $msg)
        {
            echo "Não foi possivel atualizar os dados". $msg ->getMessage();
        }      
    }
}
?>