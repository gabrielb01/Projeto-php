<?php


if (!defined('INDEX')) {
    die("Erro no sistema!");
}


class AccountsController
{

    public $title;

    public $style;

    private $database;

    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            header('Location:' . PROTOCOLO . '://' . PATH . '');
        }

        $this->database = new Database();
    }



    public function login()
    {
        $this->title = "Login";
        $this->view = new View("accounts/login");
        $this->view->render($this->title, $this->style);
    }

    public function cadastro()
    {
        $this->view = new View("accounts/cadastro");
        $this->view->render("Cadastro", $this->style);
    }


    public function forgot()
    {
        $this->view = new View("accounts/forgot");
        $this->view->render("Esqueceu a senha", $this->style);
    }

    public function gerartoken()
    {
        if ($_POST) {
            $email = trim(limpar($_POST['email']));
            $resultado = $this->database->query("SELECT id_usuario,nome,sobrenome FROM USUARIO WHERE email=:email", [':email' => $email]);

            if (count($resultado) == 0) {
                $_SESSION['ERROR_DATA_OUT'] = "Este e-mail não está cadastrado em nosso sistema.";
                header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/forgot');
            } else {
                $token = md5($email . "Conscious Vegan - Redefinição de senha");
                $parametro = [
                    ":token"    => $token,
                    ":token_ativo_password" => "1",
                    ":id"   => $resultado[0]['id_usuario']
                ];
                $this->database->exe_query("UPDATE USUARIO SET token=:token, token_ativo_password=:token_ativo_password WHERE id_usuario=:id", $parametro);

                $texto_email = "<p>Recentemente, você solicitou a redefinição da senha em sua conta Conscious Vegan.
             Por favor, use o link a seguir para criar uma nova senha.</p>
            <p><a href='" . PROTOCOLO . "://" . PATH . "/accounts/reset/" . $token . "'>." . PROTOCOLO . "://" . PATH . "/accounts/reset/" . $token . "</a></p>";


                $mail = new Email(HOST_EMAIL, EMAIL, PASSWORD_EMAIL, NAME_HOST);
                $mail->addAdress($email, $resultado[0]['nome'] . ' ' . $resultado[0]['sobrenome']);
                $mail->formatarEmail("Conscious Vegan - Redefinição de senha", $texto_email);
                if ($mail->enviarEmail()) {
                    $_SESSION['CADASTRO_SUCESSO'] = "Um e-mail foi enviado para <b>" . $email . "</b> com o link para redefinição da senha.";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/');
                } else {
                    $_SESSION['ERROR_DATA_OUT'] = "Erro ao tentar enviar o e-mail!";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/');
                }
            }
        } else {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/error');
        }
    }


    public function verificar($token)
    {
        $resultado = $this->database->query("SELECT * FROM USUARIO WHERE token=:token AND token_ativo=:ativo", [':token' => $token, ':ativo' => "1"]);
        if (count($resultado) == 0) {
            // header('Location: ' . PROTOCOLO . '://' . PATH . '/error');
            echo "OK";
            exit;
        }

        if ($resultado[0]['token_ativo'] == "1") {
            $parametro = [
                ":ativo"  => "1",
                "token_ativo" => "0",
                "token" => $token
            ];
            $this->database->exe_query("UPDATE USUARIO SET ativo=:ativo,token_ativo=:token_ativo WHERE token=:token", $parametro);

            $_SESSION['CADASTRO_SUCESSO'] = "Conta verificada com sucesso!";

            $_SESSION['user'] = $resultado[0]['id_usuario'];
            $_SESSION['usuario'] = $resultado[0]['usuario'];
            $_SESSION['nome_full'] = $resultado[0]['nome'] . " " . $resultado[0]['sobrenome'];
            $_SESSION['permissao'] = $resultado[0]['permissao'];

            header('Location: ' . PROTOCOLO . '://' . PATH . '/u/profile/' . $resultado[0]['usuario']);
        } else {
            $_SESSION["ERROR_DATA_OUT"] = "Esse token não é mais válido";
            header('Location: ' . PROTOCOLO . '://' . PATH . '/');
        }
    }

    public function reset($token)
    {
        $resultado = $this->database->query("SELECT * FROM USUARIO WHERE token=:token AND token_ativo_password=:ativo", [':token' => $token, ':ativo' => "1"]);
        if (count($resultado) == 0) {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/error');
            exit;
        }

        $this->view = new View("accounts/newpassword");
        $this->view->token = $token;
        $this->view->render("Nova senha", $this->style);
    }



    public function editarsenha($token)
    {
        if ($_POST) {
            if (isset($token)) {
                $resultado = $this->database->query("SELECT * FROM USUARIO WHERE token=:token AND token_ativo_password=:ativo", [':token' => $token, ':ativo' => "1"]);
                if ($resultado[0]['token_ativo_password'] == "1") {

                    $novasenha = trim(limpar($_POST['pass1']));
                    $novasenha2 = trim(limpar($_POST['pass2']));

                    if ($novasenha == $novasenha2) {
                        $parametro = [
                            "token_ativo_password" => "0",
                            "token" => $token
                        ];
                        $this->database->exe_query("UPDATE USUARIO SET token_ativo_password=:token_ativo_password,token='' WHERE token=:token", $parametro);

                        $hash = password_hash($novasenha, PASSWORD_DEFAULT);

                        $parametro = [
                            ":senha"    => $hash,
                            ":id"       => $resultado[0]['id_usuario']
                        ];

                        $this->database->exe_query("UPDATE USUARIO SET senha=:senha WHERE id_usuario=:id", $parametro);
                        $_SESSION['CADASTRO_SUCESSO'] = "A nova senha foi salvar, faça o login para continuar";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/login');
                    } else {
                    }
                } else {
                    $_SESSION["ERROR_DATA_OUT"] = "Esse token não é mais válido";
                    header('Location: ' . PROTOCOLO . '://' . PATH . '/');
                }
            } else {
                header('Location: ' . PROTOCOLO . '://' . PATH . '/error');
            }
        } else {
            header('Location: ' . PROTOCOLO . '://' . PATH . '/error');
        }
    }

    public function validarCadastro()
    {

        if ($_POST) {


            if ($_POST['email'] != "" && $_POST['senha'] && $_POST['usuario'] != "" && $_POST['nome'] != "" && $_POST['sobrenome']) {

                $email = trim(limpar($_POST['email']));
                $senha = trim(limpar($_POST['senha']));
                $usuario = trim(limpar($_POST['usuario']));
                $nome = trim(limpar($_POST['nome']));
                $sobrenome = trim(limpar($_POST['sobrenome']));
                

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION["ERROR_DATA_OUT"] = "Insira um e-mail válido!";
                    header('Location:' . PROTOCOLO . '://' . PATH . '/accounts/cadastro');
                } else {
                    $emailDB = $this->database->query("SELECT email FROM USUARIO WHERE email=:email",[':email' => $email]);
                   if (count($emailDB) > 0) {
                        $_SESSION["ERROR_DATA_OUT"] = "Este E-mail já estar sendo usado por outro usuário!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/cadastro');
                   } else {
                       $usuarioDB = $this->database->query("SELECT usuario FROM USUARIO WHERE usuario=:usuario",[':usuario' => $usuario]);
                    if (count($usuarioDB) > 0) {
                        $_SESSION["ERROR_DATA_OUT"] = "Este usuário já estar sendo usado por outra pessoa!";
                        header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/cadastro');
                   } else {
                         if (strlen($senha) < 8) {
                         $_SESSION["ERROR_DATA_OUT"] = "A senha deve contem no mínimo 8 caracteres";
                         header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/cadastro');
                         } else {
                             if (isset($_POST['radio'])) {
                                 $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                                 $token = md5($email);
                                 $parametro = [
                                     ":usuario" => $usuario,
                                     ":email" => $email,
                                     ":permissao" => "user",
                                     ":senha" => $senha,
                                     ":nome" => $nome,
                                     ":sobrenome" => $sobrenome,
                                     ":sexo" => $_POST['radio'],
                                     ":token" => $token,
                                     ":token_ativo" => "1",
                                     ":foto_perfil" => '/img/default/default.png'
                                 ];
 
                                 $this->database->exe_query("INSERT INTO USUARIO(usuario,email,permissao,senha,nome,sobrenome,sexo,token,token_ativo,foto_perfil) 
                                 VALUES(:usuario,:email,:permissao,:senha,:nome,:sobrenome,:sexo,:token,:token_ativo, :foto_perfil)", $parametro);
                                 $_SESSION["CADASTRO_SUCESSO"] = "Cadastro feito com sucesso, verifique seu e-mail para fazer a confirmação da conta!";
 
                                 $texto_email = "<h4>Parabéns, você acabou de criar sua conta no Conscious Vegan <b>= )</b>.</h4>
                                                 <p>Primeiramente, vamos confirmar sua conta de E-mail.</p>
                                                 <p>Então, para isso clique no link abaixo.</p>
                                                 <p><a href='" . PROTOCOLO . "://" . PATH . "/accounts/verificar/" . $token . "'>confirmar conta.</a></p>";
 
 
                                 $mail = new Email(HOST_EMAIL, EMAIL, PASSWORD_EMAIL, NAME_HOST);
                                 $mail->addAdress($email, $nome . ' ' . $sobrenome);
                                 $mail->formatarEmail("Conta criada com sucesso", $texto_email);
                                 $mail->enviarEmail();
 
 
                                 header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/login');
                             } else {
                                 $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                                 header('Location: ' . PROTOCOLO . '://' . PATH . '/accounts/cadastro');
                             }
                         }
                     }
                   }
                }
            } else {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location:' . PROTOCOLO . '://' . PATH . '/accounts/cadastro');
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }



    public function validarLogin()
    {
        if ($_POST) {
            if ($_POST['email'] == "" || $_POST['senha'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location:' . PROTOCOLO . '://' . PATH . '/accounts/login');
            } else {
                $email = trim(limpar($_POST['email']));
                $senha = trim(limpar($_POST['senha']));

                $parametro = [
                    ":email" => $email
                ];

                $resultado = $this->database->query("SELECT * FROM USUARIO WHERE email=:email", $parametro);


                if (!$resultado) {
                    $_SESSION["ERROR_DATA_OUT"] = "E-mail ou senha esta incorreta";
                    header('Location:' . PROTOCOLO . '://' . PATH . '/accounts/login');
                } else {
                    if (!password_verify($senha, $resultado[0]['senha'])) {
                        $_SESSION["ERROR_DATA_OUT"] = "E-mail ou senha esta incorreta";
                        header('Location:' . PROTOCOLO . '://' . PATH . '/accounts/login');
                    } else {


                        if ($resultado[0]['ativo'] == 0) {
                            $_SESSION["ERROR_DATA_OUT"] = "Para fazer o login, primeiramente faça a ativação da conta, nós enviamos o link de ativação para <b>".$email.'</b>';
                            header('Location:' . PROTOCOLO . '://' . PATH . '/accounts/login');
                        } else {
                            $_SESSION['user'] = $resultado[0]['id_usuario'];
                            $_SESSION['usuario'] = $resultado[0]['usuario'];
                            $_SESSION['nome_full'] = $resultado[0]['nome'] . " " . $resultado[0]['sobrenome'];
                            $_SESSION['permissao'] = $resultado[0]['permissao'];
    
                            header('Location:' . PROTOCOLO . '://' . PATH . '/u/profile/' . $_SESSION['usuario'] . '');
                        }
                    }
                }
            }
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['usuario']);
            unset($_SESSION['nome_full']);
            unset($_SESSION['permissao']);
            unset($_SESSION['ativo']);
            header('Location:' . PROTOCOLO . '://' . PATH . '');
        } else {
            header("Location:" . PROTOCOLO . "://" . PATH . "/error");
        }
    }
}
