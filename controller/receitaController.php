<?php

class ReceitaController
{

    private $database;
    private $title;
    private $style;

    public function __construct()
    {

        $this->database = new Database();

        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/login');
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

        require_once "view/receita/receita.php";


        require_once "view/footer.php";
    }

    public function detalhes()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";

        require_once "view/receita/receitas.php";


        require_once "view/footer.php";
    }

    public function new()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";

        require_once "view/receita/novareceita.php";


        require_once "view/footer.php";
    }


    public function single($id)
    {
        //Mostrar uma única receita
        require_once "view/head.php";

        require_once "view/navegacao.php";

        require_once "view/receita/singleReceita.php";


        require_once "view/footer.php";
    }


    function edit($id)
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";

        require_once "view/receita/editreceita.php";


        require_once "view/footer.php";
    }

    public function Search()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";

        require_once "view/receita/searchreceita.php";


        require_once "view/footer.php";
    }



    public function validarNovaReceita()
    {
        if ($_POST) {
            if ($_POST['nomeReceita'] == "" || $_POST['ingredientes'] == "" || $_POST['descricao'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/new');
            } else {

                $nomeReceita = trim(limpar($_POST['nomeReceita']));
                $ingredientes = trim(limpar($_POST['ingredientes']));
                $descricao = trim(limpar($_POST['descricao']));

                $type_in = ['png', 'jpg', 'jpeg'];
                $tipo_image = explode("/", $_FILES["fotoReceita"]["type"]);
                $tipo_image[1] = strtolower($tipo_image[1]);
                if ($tipo_image[0] != "image") {
                    $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/new');
                } else {
                    if (!in_array($tipo_image[1], $type_in)) {
                        $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg 2";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/new');
                    } else {
                        $img_receita = md5(strval(date("Y-m-d H:i:s")) . $_FILES['fotoReceita']['name']);
                        $destino = "img/receitas/";
                        $novoNome = $img_receita . '.' . $tipo_image[1];
                        $arquivo_tmp = $_FILES['fotoReceita']['tmp_name'];

                        if (move_uploaded_file($arquivo_tmp, $destino . $novoNome)) {
                            $parametros = [
                                ':titulo'   => $nomeReceita,
                                ':ingredientes' => $ingredientes,
                                ':mododefazer'    => $descricao,
                                ':foto_receita' => $destino . $novoNome,
                                ':categoria'    => $_POST['categoria'],
                                ':criando_em'   =>  date("Y-m-d H:i:s"),
                                ':id_usuario'  => $_SESSION['user']
                            ];

                            $this->database->exe_query("INSERT INTO RECEITA(titulo,ingredientes,mododefazer,foto_receita,categoria,criando_em,id_usuario)
                            VALUES(:titulo,:ingredientes,:mododefazer,:foto_receita,:categoria,:criando_em,:id_usuario)", $parametros);



                            $_SESSION["SUCCESS_DATA_IN"] = "Receita adicionada com sucesso!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/detalhes');
                        } else {
                            $_SESSION["ERROR_DATA_OUT"] = "Erro ao tentar enviar a imagem, tente novamente!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/new');
                        }
                    }
                }
            }
        } else {
            header("Location:".PROTOCOLO."://".PATH."/error");
        }
    }
    
    public function validarEditReceita($id)
    {
        if ($_POST) {
            if ($_POST['nomeReceita'] == "" || $_POST['ingredientes'] == "" || $_POST['descricao'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/edit/' . $id);
            } else {

                $nomeReceita = trim(limpar($_POST['nomeReceita']));
                $ingredientes = trim(limpar($_POST['ingredientes']));
                $descricao = trim(limpar($_POST['descricao']));


                if ($_FILES['fotoReceita']['name']!="") {
                    $type_in = ['png', 'jpg', 'jpeg'];
                    $tipo_image = explode("/", $_FILES["fotoReceita"]["type"]);
                    $tipo_image[1] = strtolower($tipo_image[1]);
                    if ($tipo_image[0] != "image") {
                        $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/edit/' . $id);
                    } else {
                        if (!in_array($tipo_image[1], $type_in)) {
                            $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg 2";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/edit/' . $id);
                        } else {
                            $img_receita = md5(strval(date()) . $_FILES['fotoReceita']['name']);
                            $destino = "img/receitas/";
                            $novoNome = $img_receita . '.' . $tipo_image[1];
                            $arquivo_tmp = $_FILES['fotoReceita']['tmp_name'];

                            if (move_uploaded_file($arquivo_tmp, $destino . $novoNome)) {
                                $parametros = [
                                    ':titulo'   =>  $nomeReceita,
                                    ':ingredientes' => $ingredientes,
                                    ':mododefazer'    => $descricao,
                                    ':foto_receita' => $destino . $novoNome,
                                    ':categoria'    => $_POST['categoria'],
                                    ':id_receita'  => $id
                                ];

                                $this->database->exe_query("UPDATE RECEITA SET titulo=:titulo,ingredientes=:ingredientes,mododefazer=:mododefazer,
                            foto_receita=:foto_receita,categoria=:categoria WHERE id_receita=:id_receita", $parametros);



                                $_SESSION["SUCCESS_DATA_IN"] = "Receita editada com sucesso!";
                                header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/single/' . $id);
                            } else {
                                $_SESSION["ERROR_DATA_OUT"] = "Erro ao tentar enviar a imagem, tente novamente!";
                                header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/single/' . $id);
                            }
                        }
                    }
                } else {
                    $parametros = [
                        ':titulo'   => $nomeReceita,
                        ':ingredientes' => $ingredientes,
                        ':mododefazer'    => $descricao,
                        ':categoria'    => $_POST['categoria'],
                        ':id_receita'  => $id
                    ];

                    $this->database->exe_query("UPDATE RECEITA SET titulo=:titulo,ingredientes=:ingredientes,mododefazer=:mododefazer,
                    categoria=:categoria WHERE id_receita=:id_receita", $parametros);



                    $_SESSION["SUCCESS_DATA_IN"] = "Receita editada com sucesso!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/single/' . $id);
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

        $this->database->exe_query("DELETE FROM RECEITA WHERE id_receita=:id", $parametro);
        header('Location: ' . PROTOCOLO . '://' . PATH . '/receita');
    }
}
