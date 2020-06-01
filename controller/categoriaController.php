<?php

class CategoriaController
{


    public $database;

    function __construct()
    {
        $this->database = new Database();


        if (isset($_SESSION['permissao'])) {
            $permissão = explode(";",$_SESSION['permissao']);
           if (!in_array("admin",$permissão)) {
            header('Location: ' .PROTOCOLO. '://'.PATH.'/error');
           }
          }
        

        if (!isset($_SESSION['user'])) {
            header('Location: ' .PROTOCOLO. '://'.PATH.'/autenticacao/login');
        }
    }


    function getConnect()
    {
        return $this->database;
    }


    function index()
     {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/categoria.php";

        require_once "view/footer.php";
    }


    function new()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/novaCategoria.php";

        require_once "view/footer.php";   
    }


    function edit($id)
    {
        
        require_once "view/head.php";
       
        require_once "view/navegacao.php";        
       
        require_once "view/editcategoria.php";
       
        require_once "view/footer.php";
          
    }


    function validarNovaCategoria()
    {
        if ($_POST) {
            if ($_POST['categoria']=="" || $_POST['descricao']=="") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/new');
            } else {



                $parametro = [
                    ":categoria" => $_POST['categoria']
                ];

                $resultado = $this->database->query("SELECT nome_categoria FROM CATEGORIA WHERE nome_categoria=:categoria",$parametro);

                if(count($resultado) !=0) {
                    $_SESSION["ERROR_DATA_OUT"] = "Está categoria já existem, escolha outra nome de categoria!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/new');
                } else {
                    $parametro = [
                        ":categoria" => $_POST['categoria'],
                        ":descricao" => $_POST['descricao']
                    ];

                    $this->database->exe_query("INSERT INTO CATEGORIA(nome_categoria,descricao) VALUES (:categoria,:descricao)",$parametro);
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria');
                }
            }
        } else {
            new ErrorController();
        }
    }

    function validarEdit($id)
    {
        if($_POST) {
            if ($_POST['categoria']=="" || $_POST['descricao']=="") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/edit/'.$id.'');
            } else {
                $parametro = [
                    ":categoria" => $_POST['categoria'],
                    ":id"        => $id
                ];

                $resultado = $this->database->query("SELECT nome_categoria FROM CATEGORIA WHERE nome_categoria=:categoria AND id_categoria!=:id",$parametro);

                if(count($resultado) !=0) {
                    $_SESSION["ERROR_DATA_OUT"] = "Está categoria já existem, escolha outra nome de categoria!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/edit/'.$id.'');
                } else {
                    $parametro = [
                        ":categoria" => $_POST['categoria'],
                        ":descricao" => $_POST['descricao'],
                        ":id"        => $id
                    ];

                    $this->database->exe_query("UPDATE CATEGORIA SET nome_categoria=:categoria,descricao=:descricao WHERE id_categoria=:id",$parametro);
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria');
                }
                

            }
        } else {
            new ErrorController();
        }
    }

    function excluir($id)
    {
        $parametro = [
            ":id"   => $id
        ];

        $this->database->exe_query("DELETE FROM CATEGORIA WHERE id_categoria=:id",$parametro);
        header('Location: '.PROTOCOLO. '://'.PATH.'/categoria');
    }


  
}




?>