<?php
// classe usuário


if (!defined('INDEX')) {
  die("Erro no sistema!");
}

class UController
{

    public $title;
    public $style;
    private $database;

    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/login');
        }

        $this->title =$_SESSION['nome_full'];
        $this->database = new Database();

        $user = $this->database->query("SELECT ativo FROM USUARIO WHERE id_usuario=:id",[':id' => $_SESSION['user']]);
        if ($user[0]['ativo'] =="0") {
            $_SESSION["ERROR_DATA_OUT"] = "Para você pode usar sua conta, primeiro é preciso verificar seu e-mail";
            header('Location:' . PROTOCOLO . '://' . PATH . '/');
        }

        
    }

   
    public function profile($usuario)
    {
        $dados = $this->database->query("SELECT * FROM USUARIO WHERE usuario = :usuario", [":usuario" => $usuario]);

        $this->title = $_SESSION['nome_full'];
        $this->view = new View("usuario/profile");
        $this->view->dados = $dados;
        $this->view->usuario = $usuario;
        $this->view->render($this->title,$this->style);
    }


    public function edit($acao)
    {
        $this->title = $_SESSION['nome_full'];

        $database = new Database();

        $dados = $this->database->query("SELECT * FROM USUARIO WHERE id_usuario = :id", [":id" => $_SESSION['user']]);

        $this->view = new View("usuario/editprofile");
        $this->view->dados = $dados;
        $this->view->acao = $acao;
        $this->view->render($this->title,$this->style);
    }


    public function listar()
    {
        // Listar todas as receitas salvas pelo usuário.
        $dados = $this->database->query("SELECT receitas_salvas FROM USUARIO WHERE id_usuario = :id", [":id" => $_SESSION['user']]);

        $lista_receitas = explode(';',$dados[0]['receitas_salvas']);

        $lista_receitas = implode(",",$lista_receitas);

        $receitas = $this->database->query("SELECT * FROM RECEITA WHERE id_receita IN (".$lista_receitas.")");

        $this->title = "Receitas Salvas";
       
        $this->view = new View("usuario/listar");
        $this->view->dados = $receitas;

        $this->view->render($this->title,$this->style);
    }


    public function editphoto()
    {
        if ($_FILES) {
            $type_in = ['png', 'jpg', 'jpeg'];
            $tipo_image = explode("/", $_FILES["fotoProfile"]["type"]);
            $tipo_image[1] = strtolower($tipo_image[1]);
            if ($tipo_image[0] != "image") {
                $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg";
                header('Location: ' . PROTOCOLO . '://' . PATH . '/u/profile');
            } else {
                if (!in_array($tipo_image[1], $type_in)) {
                    $_SESSION["ERROR_DATA_OUT"] = "Escolha Imagem do tipo png ou jpg ";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/u/profile');
                } else {
                    $img_profile = md5(strval(date("Y-m-d H:i:s")) . $_FILES['fotoProfile']['name']);
                    $destino = "img/profile/";
                    $novoNome = $img_profile . '.' . $tipo_image[1];
                    $arquivo_tmp = $_FILES['fotoProfile']['tmp_name'];

                    if (move_uploaded_file($arquivo_tmp, $destino . $novoNome)) {
                        $parametros = [
                            ':foto_perfil' => $destino . $novoNome,
                            ":id_usuario"  => $_SESSION['user']
                        ];

                        $this->database->exe_query("UPDATE USUARIO SET foto_perfil=:foto_perfil WHERE id_usuario=:id_usuario", $parametros);



                        $_SESSION["CADASTRO_SUCESSO"] = "Foto do perfil alterada com sucesso!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/u/profile');
                    } else {
                        $_SESSION["ERROR_DATA_OUT"] = "Erro ao tentar alterar a foto do perfil, tente novamente!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/u/profile/');
                    }
                }
            }
        }
    }

    public function editarDadosUsuario()
    {
        if ($_POST) {
            if ($_POST['form'] == "formFullName") {
                if ($_POST['nome'] != "" && $_POST['sobrenome'] != "") {

                    $nome = trim(limpar($_POST['nome']));
                    $sobrenome = trim(limpar($_POST['sobrenome']));

                    $parametro = [
                        ":nome" => $nome,
                        ":sobrenome" => $sobrenome,
                        ":id" => $_SESSION['user']
                    ];
                    $this->database->exe_query("UPDATE USUARIO SET nome=:nome,sobrenome=:sobrenome WHERE id_usuario=:id", $parametro);
                    $_SESSION['nome_full'] =$nome . ' ' .$sobrenome;
                    $_SESSION["CADASTRO_SUCESSO"] = "Tudo foi salvo!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-perfil');
                } else {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-usuario');
                }
            } else if ($_POST['form'] == "usuario_c") {
                if ($_POST['usuario'] == "") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-usuario');
                } else {
                    $usuario = trim(limpar($_POST['usuario']));
                    if ($usuario == $_SESSION['usuario']) {
                        $_SESSION["ERROR_DATA_OUT"] = "Você colocou o mesmo nome de usuário!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-usuario');
                    } else {
                        $parametro = [
                            ":usuario" => $usuario,
                            ":id" => $_SESSION['user']
                        ];
                        $resultado = $this->database->query("SELECT usuario FROM USUARIO WHERE usuario=:usuario AND id_usuario!=:id", $parametro);
                        if (count($resultado) == 0) {
                            $parametro = [
                                ":usuario" => $usuario,
                                ":id" => $_SESSION['user']
                            ];
                            $this->database->exe_query("UPDATE USUARIO SET usuario=:usuario WHERE id_usuario=:id", $parametro);
                            $_SESSION['usuario'] = $_POST['usuario'];
                            $_SESSION["CADASTRO_SUCESSO"] = "Tudo foi salvo!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-usuario');
                        }
                    }
                }
            } else if ($_POST['form'] == "email_c") {
                if ($_POST['email'] == "") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-email');
                } else {
                    $email = trim(limpar($_POST['email']));
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION["ERROR_DATA_OUT"] = "Insira um e-mail válido!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-email');
                    } else {

                        $parametro = [
                            ":email" => $email
                        ];

                        $resultado = $this->database->query("SELECT email FROM USUARIO WHERE email=:email", $parametro);
                        if (count($resultado) != 0) {
                            if ($email == $resultado[0]['email']) {
                                $_SESSION["ERROR_DATA_OUT"] = "Você colocou o mesmo nome de usuário!";
                                header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-email');
                            } else {
                                $_SESSION["ERROR_DATA_OUT"] = "Este email não está disponível, escolha outro!";
                                header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-email');
                            }
                        } else {
                            $parametro = [
                                ":email" => $email,
                                ":id" => $_SESSION['user']
                            ];
                            $this->database->exe_query("UPDATE USUARIO SET email=:email WHERE id_usuario=:id", $parametro);
                            $_SESSION["CADASTRO_SUCESSO"] = "Tudo foi salvo!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-email');
                        }
                    }
                }
            } else if ($_POST['form'] == "senha_c") {
                if ($_POST['senha'] == "" && $_POST['senha2'] == "" && $_POST['senha_original'] == "") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-senha');
                } else {
                    $senha = trim(limpar($_POST['senha']));
                    $senha2 = trim(limpar($_POST['senha2']));
                    $senha_original = trim(limpar($_POST['senha_original']));
                    if ($senha != $senha2) {
                        $_SESSION["ERROR_DATA_OUT"] = "Você deve escrever a nova senha iguais nos campos!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-senha');
                    } else {
                        if (strlen($senha) < 8) {
                            $_SESSION["ERROR_DATA_OUT"] = "A senha de contém no mínimo 8 caracteres!";
                            header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-senha');
                        } else {
                            $parametro = [
                                ":id" => $_SESSION['user']
                            ];
                            $resultado = $this->database->query("SELECT senha FROM USUARIO WHERE id_usuario=:id", $parametro);

                            if (!password_verify($senha_original, $resultado[0]['senha'])) {
                                $_SESSION["ERROR_DATA_OUT"] = "A sua senha está errada [primeiro campo]!";
                                header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-senha');
                            } else {
                                $parametro = [
                                    ":senha" => password_hash($senha, PASSWORD_DEFAULT),
                                    ":id" => $_SESSION['user']
                                ];
                                $this->database->exe_query("UPDATE USUARIO SET senha=:senha WHERE id_usuario=:id", $parametro);
                                $_SESSION["CADASTRO_SUCESSO"] = "Tudo foi salvo!";
                                header('Location: ' . PROTOCOLO . '://' . PATH . '/u/edit/editar-senha');
                            }
                        }
                    }
                }
            } else if ($_POST['form'] == "excluir") {

                if (isset($_SESSION['user'])) {
                    $parametro = [
                        ":id" => $_SESSION['user']
                    ];
                    $this->database->exe_query("DELETE FROM USUARIO WHERE id_usuario=:id", $parametro);
                    $this->database->exe_query("DELETE FROM RECEITA WHERE id_usuario=:id",$parametro);
                    $_SESSION["CADASTRO_SUCESSO"] = "Sua conta foi excluída!";
                    unset($_SESSION['user']);
                    unset($_SESSION['usuario']);
                    unset($_SESSION['nome_full']);
                    unset($_SESSION['permissao']);
                    header('Location:' . PROTOCOLO . '://' . PATH . '');
                } else {
                    header("Location:" . PROTOCOLO . "://" . PATH . "/error");  
                    echo "OK"; 
                }
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }
}
