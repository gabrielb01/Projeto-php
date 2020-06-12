<?php 

class Database 
{
    
    public $pdo;




    function query($query, $parametro = null)
    {
        try {
            $this->pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);

            if ($parametro == null) {
                $acao = $this->pdo->prepare($query);
                $acao->execute();
                $resultado = $acao->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $acao = $this->pdo->prepare($query);
                $acao->execute($parametro);
                $resultado = $acao->fetchAll(PDO::FETCH_ASSOC);
            }
            
            $this->pdo = null;
            return $resultado;
    
        } catch(PDOException $e) {
            echo "Não foi possivel conectar, tente novamente mais tarde!";
        }
    }


    function exe_query($query,$parametro=null)

    {
        
        try {
            $this->pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);

            $this->pdo->beginTransaction();

            if ($parametro== null) { 
                $acao = $this->pdo->prepare($query);
                $acao->execute();
            } else {
                $acao = $this->pdo->prepare($query);
                $acao->execute($parametro);
            } 

            $this->pdo->commit();

        } catch(PDOException $e) {
            echo "Não foi possivel conectar, tente novamente mais tarde!";
            $this->pdo->rollBack();
        }
            

        $this->pdo = null;
 
    }
}
