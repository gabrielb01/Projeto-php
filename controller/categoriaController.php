<?php

class CategoriaController
{


    private $database;
    private $title;

    public function __construct()
    {
        $this->database = new Database();


        if (isset($_SESSION['permissao'])) {
            $permissão = explode(";",$_SESSION['permissao']);
           if (!in_array("admin",$permissão)) {
            header('Location: ' .PROTOCOLO. '://'.PATH.'/error');
           }
          }
        

        if (!isset($_SESSION['user'])) {
            header('Location: ' .PROTOCOLO. '://'.PATH.'/accounts/login');
        }
    }

    public function setTitle($title)
    {
        $this->title =$title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setStyle($style)
    {
        $this->style = $style;
    }

    public function getStyle()
    {
        return $this->style;
    }


    public function getConnect()
    {
        return $this->database;
    }


    public function index()
     {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/categoria/categoria.php";

        require_once "view/footer.php";
    }


    public function new()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/categoria/novaCategoria.php";

        require_once "view/footer.php";   
    }


    public function edit($id)
    {
        
        require_once "view/head.php";
       
        require_once "view/navegacao.php";        
       
        require_once "view/categoria/editcategoria.php";
       
        require_once "view/footer.php";
          
    }

    public function show($name)
    {
        require_once "view/head.php";
       
        require_once "view/navegacao.php";        
       
        require_once "view/showcategoria.php";
       
        require_once "view/footer.php";
    }


    public function validarNovaCategoria()
    {
        if ($_POST) {
            if ($_POST['categoria']=="" || $_POST['descricao']=="") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/new');
            } else {

                $categoria =trim(limpar($_POST['categoria']));
                $descricao =trim(limpar($_POST['descricao']));
                
                $parametro = [
                    ":categoria" => $categoria
                ];

                $resultado = $this->database->query("SELECT nome_categoria FROM CATEGORIA WHERE nome_categoria=:categoria",$parametro);

                if(count($resultado) !=0) {
                    $_SESSION["ERROR_DATA_OUT"] = "Está categoria já existem, escolha outra nome de categoria!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/new');
                } else {
                    $parametro = [
                        ":categoria" => $categoria,
                        ":descricao" => $descricao
                    ];

                    $this->database->exe_query("INSERT INTO CATEGORIA(nome_categoria,descricao) VALUES (:categoria,:descricao)",$parametro);
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria');
                }
            }
        } else {
            header("Location:".PROTOCOLO."://".PATH."/error");
        }
    }

    public function validarEdit($id)
    {
        if($_POST) {
            if ($_POST['categoria']=="" || $_POST['descricao']=="") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/edit/'.$id.'');
            } else {
                $categoria =trim(limpar($_POST['categoria']));
                $descricao =trim(limpar($_POST['descricao']));
                $parametro = [
                    ":categoria" => $categoria,
                    ":id"        => $id
                ];

                $resultado = $this->database->query("SELECT nome_categoria FROM CATEGORIA WHERE nome_categoria=:categoria AND id_categoria!=:id",$parametro);

                if(count($resultado) !=0) {
                    $_SESSION["ERROR_DATA_OUT"] = "Está categoria já existem, escolha outra nome de categoria!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria/edit/'.$id.'');
                } else {
                    $parametro = [
                        ":categoria" =>$categoria,
                        ":descricao" => $descricao,
                        ":id"        => $id
                    ];

                    $this->database->exe_query("UPDATE CATEGORIA SET nome_categoria=:categoria,descricao=:descricao WHERE id_categoria=:id",$parametro);
                    header('Location: '.PROTOCOLO. '://'.PATH.'/categoria');
                }
                

            }
        } else {
            header("Location:".PROTOCOLO."://".PATH."/error");
        }
    }

    public function excluir($id)
    {
        $parametro = [
            ":id"   => $id
        ];

        $this->database->exe_query("DELETE FROM CATEGORIA WHERE id_categoria=:id",$parametro);
        header('Location: '.PROTOCOLO. '://'.PATH.'/categoria');
    }


  
}




?>