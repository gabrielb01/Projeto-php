<?php


if (!defined('INDEX')) {
  die("Erro no sistema!");
}

class ReceitaController
{

    private $database;
    public $title;
    public $style;

    public function __construct()
    {

        $this->database = new Database();

        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/login');
        }


        $user = $this->database->query("SELECT ativo FROM USUARIO WHERE id_usuario=:id",[':id' => $_SESSION['user']]);
        if ($user[0]['ativo'] =="0") {
            $_SESSION["ERROR_DATA_OUT"] = "Para você pode usar sua conta, primeiro é preciso verificar seu e-mail";
            header('Location:' . PROTOCOLO . '://' . PATH . '/');
        }
    }

    

    public function index()
    {
        //Mostrar todas as receitas

        $receitas = $this->database->query("SELECT * FROM RECEITA ORDER BY criando_em DESC");

        $this->view = new View("receita/receita");
        $this->view->receitas = $receitas;
        $this->view->render($this->title,$this->style);
    }

    public function detalhes($id)
    {
        //Mostrar apenas as receitas adicionadas pelo o usuário

        $receitas = $this->database->query("SELECT * FROM RECEITA WHERE id_usuario=:id ORDER BY criando_em DESC", [':id' => $id]);

        $this->view = new View("receita/receitas");
        $this->view->receitas = $receitas;
        $this->view->id = $id;
        $this->view->render($this->title,$this->style);
    }

    public function new()
    {
        $this->view = new View("receita/novareceita");
        $this->view->database = $this->database;
        $this->view->render($this->title,$this->style);
    }


    public function single($id)
    {
        //Mostrar uma única receita
        

        $receita = $this->database->query("SELECT * FROM RECEITA WHERE id_receita=:id", [':id' => $id]);

        if (count($receita)==0) { 
            header("Location:".PROTOCOLO."://".PATH."/error");
        }

        $this->title = $receita[0]['titulo'];
        
        $criador = $this->database->query("SELECT usuario,nome,sobrenome FROM USUARIO WHERE id_usuario=:id", [":id" => $receita[0]['id_usuario']]);

        $ingredientes = explode(',', $receita[0]['ingredientes']);

        $receitas_salvas = $this->database->query("SELECT receitas_salvas FROM USUARIO WHERE id_usuario=:id", [':id' => $_SESSION['user']]);


        $receitas_salvas = explode(";", $receitas_salvas[0]['receitas_salvas']);

        $this->view = new View("receita/singleReceita");
        $this->view->receita = $receita;
        $this->view->criador = $criador;
        $this->view->ingredientes = $ingredientes;
        $this->view->receitas_salvas = $receitas_salvas;
        $this->view->render($this->title,$this->style);
        
    }


    public function edit($id)
    {

        $receita = $this->database->query("SELECT * FROM RECEITA WHERE id_receita=:id", [":id" => $id]);
        $ingredientes = explode(',', $receita[0]['ingredientes']);

        if (count($receita) == 0) {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }

        $this->view = new View("receita/editreceita");
        $this->view->receita = $receita;
        $this->view->ingredientes = $ingredientes;
        $this->view->database = $this->database;
        $this->view->render($this->title,$this->style);
    }

    public function Search()
    {

        $search = trim(limpar($_POST['search']));

        $receitas = $this->database->query("SELECT * FROM RECEITA WHERE titulo LIKE '%" . $search . "%'");

        if (!count($receitas) == 0) {
            $this->view = new View("receita/searchreceita");
            $this->view->receitas = $receitas;
            $this->view->render($this->title,$this->style);
        } else {
            $this->view = new View("receita/notfoundreceita");
            $this->view->render($this->title,$this->style);
            
        }


        
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
                        $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg ";
                        echheader('Location: ' . PROTOCOLO . '://' . PATH . '/receita/new');
                    } else {
                        $img_receita = md5(strval(date("Y-m-d H:i:s")) . $_FILES['fotoReceita']['name']);
                        $destino = "img/receita/";
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



                            $_SESSION["CADASTRO_SUCESSO"] = "Receita adicionada com sucesso!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/detalhes/'.$_SESSION['user']);
                        } else {
                            $_SESSION["ERROR_DATA_OUT"] = "Erro ao tentar enviar a imagem, tente novamente!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/new');
                        }
                    }
                }
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
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


                if ($_FILES['fotoReceita']['name'] != "") {
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



                                $_SESSION["CADASTRO_SUCESSO"] = "Receita editada com sucesso!";
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



                    $_SESSION["CADASTRO_SUCESSO"] = "Receita editada com sucesso!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/receita/single/' . $id);
                }
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }


    public function excluir($id)
    {
        $user = $this->database->query("SELECT id_usuario FROM RECEITA WHERE id_receita=:id", [":id" => $id]);

        if (isset($_SESSION['user']) && $user[0]['id_usuario'] == $_SESSION['user']) {
            $parametro = [
                ":id"   => $id
            ];

            $this->database->exe_query("DELETE FROM RECEITA WHERE id_receita=:id", $parametro);
            header('Location: ' . PROTOCOLO . '://' . PATH . '/receita');
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }
}
