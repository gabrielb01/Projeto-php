<?php

class CategoriaController
{


    public $database;
    public $title;
    public $style;

    public function __construct()
    {
        $this->database = new Database();


        if (isset($_SESSION['permissao'])) {
            $permissão = explode(";", $_SESSION['permissao']);
            if (!in_array("admin", $permissão)) {
                header('Location: ' . PROTOCOLO . '://' . PATH . '/error');
            }
        }


        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/login');
        }
    }




    public function index()
    {
        $this->view = new View("categoria/categoria");
        $this->view->database =  $this->database;
        $this->view->render($this->title, $this->style);
    }


    public function new()
    {
        $this->view = new View("categoria/novaCategoria");
        $this->view->render($this->title, $this->style);
    }


    public function edit($id)
    {
        $parametro = [':id'   => $id];

        $resultado = $this->database->query("SELECT * FROM CATEGORIA WHERE id_categoria=:id", $parametro);

        if (count($resultado) == 0) {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }

        $this->view = new View("categoria/editcategoria");
        $this->view->id = $id;
        $this->view->resultado = $resultado;
        $this->view->render($this->title, $this->style);
    }

    public function show($name)
    {
        $receitas = $this->database->query("SELECT * FROM RECEITA WHERE categoria=:categoria", [':categoria' => $name]);

        if (count($receitas) == 0) {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }

        $this->view = new View("categoria/showcategoria");
        $this->view->receitas = $receitas;
        $this->view->render($this->title, $this->style);
    }


    public function validarNovaCategoria()
    {
        if ($_POST) {
            if ($_POST['categoria'] == "" || $_POST['descricao'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria/new');
            } else {

                $categoria = trim(limpar($_POST['categoria']));
                $descricao = trim(limpar($_POST['descricao']));

                $parametro = [
                    ":categoria" => $categoria
                ];

                $resultado = $this->database->query("SELECT nome_categoria FROM CATEGORIA WHERE nome_categoria=:categoria", $parametro);

                if (count($resultado) != 0) {
                    $_SESSION["ERROR_DATA_OUT"] = "Está categoria já existem, escolha outra nome de categoria!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria/new');
                } else {
                    $parametro = [
                        ":categoria" => $categoria,
                        ":descricao" => $descricao
                    ];

                    $this->database->exe_query("INSERT INTO CATEGORIA(nome_categoria,descricao) VALUES (:categoria,:descricao)", $parametro);
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria');
                }
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }

    public function validarEdit($id)
    {
        if ($_POST) {
            if ($_POST['categoria'] == "" || $_POST['descricao'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria/edit/' . $id . '');
            } else {
                $categoria = trim(limpar($_POST['categoria']));
                $descricao = trim(limpar($_POST['descricao']));
                $parametro = [
                    ":categoria" => $categoria,
                    ":id"        => $id
                ];

                $resultado = $this->database->query("SELECT nome_categoria FROM CATEGORIA WHERE nome_categoria=:categoria AND id_categoria!=:id", $parametro);

                if (count($resultado) != 0) {
                    $_SESSION["ERROR_DATA_OUT"] = "Está categoria já existem, escolha outra nome de categoria!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria/edit/' . $id . '');
                } else {
                    $parametro = [
                        ":categoria" => $categoria,
                        ":descricao" => $descricao,
                        ":id"        => $id
                    ];

                    $this->database->exe_query("UPDATE CATEGORIA SET nome_categoria=:categoria,descricao=:descricao WHERE id_categoria=:id", $parametro);
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria');
                }
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }

    public function excluir($id)
    {

        if (isset($_SESSION['user']) && isset($_SESSION['permissao']) && $_SESSION['permissao'] == "user;admin") {
            $parametro = [
                ":id"   => $id
            ];

            $this->database->exe_query("DELETE FROM CATEGORIA WHERE id_categoria=:id", $parametro);
            header('Location: ' . PROTOCOLO . '://' . PATH . '/categoria');
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }
}
