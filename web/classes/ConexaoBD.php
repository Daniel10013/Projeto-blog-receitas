<?php 

class conexaoBD
{
    private $server = 'localhost';
    private $bd = 'BLOG_CULINARIA';
    private $user = 'root';
    private $password = '';
    private $conn;

    //metodos
        //construtor executa sempre que a classe é iniciada
    public function __construct()
    {
        try //validar a execução do codigo //cria a conexão usando PDO
        {
            $this->conn = new PDO("mysql:host={$this->server}; dbname={$this->bd}; charset=utf8",$this->user, $this->password);
        }
        catch(PDOException $msg)
        {
            echo"Não foi possível conectar com o banco de dados - ".$msg->getMessage();
        }
    }

    //metodo para executar comandos (insert; update; delete;)
    public function execute_Query($comando)
    {
        try
        {
            //variavel que recebe o comando
            $sql = $this->conn->prepare($comando);
            //executar o comando no servidor
            $sql->execute();
            //testar se o comando deu certo, qntd de linhas maior que zero
            if($sql->rowCount() > 0)
            {
                //devolver para a tela o resultado do comando
                return '1';
            }
            else//comando deu errado
            {
                return $sql->errorInfo();//devolver para a tela o erro do mando
            }
        }
        catch (PDOException $msg)
        {
            echo"Não foi possível executar o comando: ".$msg->getMessage();
        }
    }

    //metodo para executar select
    public function execute_Select($comando)
    {
        try
        {
            //variavel que recebe o comando sql
            $sql = $this->conn->prepare($comando);
            //executar o comando no servidor
            $sql -> execute();
                //testar se o comando deu certo, qntd de linhas maior que zero
            if($sql->rowCount() > 0)
            {
                //devolver para a tela resultados do select
                //fetchAll -> retorna todos os dados do select
                //fetch Class -> devolve formato linha/coluna ->alunos -> nome; (classe)
                //fetch assoc -> devolve formato linha/coluna ->alunos["nome"]; (vetor)
                return $sql->fetchAll(PDO::FETCH_CLASS);
            }
            else//comando deu errado
            {
                return $sql->errorInfo();//devolver para a tela o erro do comando
            }
        }
        catch(PDOException $msg)
        {
            echo"Não foi possível executar o select: ".$msg->getMessage();
        }

    }
}
?>