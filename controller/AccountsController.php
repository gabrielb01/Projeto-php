<?php


Class AccountsController
{

    public $title;

    public $style;

    private $database;

    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            header('Location:' .PROTOCOLO. '://'.PATH.'');
        }

        $this->database = new Database();

    }



    public function login()
    {
        $this->view = new View("accounts/login");
        $this->view->render($this->title,$this->style);
    }

    public function cadastro()
    {
        $this->view = new View("accounts/cadastro");
        $this->view->render($this->title,$this->style);
    }

    public function validarCadastro() 
    {

        if ($_POST){


            if ($_POST['email'] != "" && $_POST['senha'] && $_POST['usuario'] != "" && $_POST['nome'] !="" && $_POST['sobrenome']) {
             
                $email =trim(limpar($_POST['email']));
                $senha =trim(limpar($_POST['senha']));
                $usuario =trim(limpar($_POST['usuario']));
                $nome =trim(limpar($_POST['nome']));
                $sobrenome =trim(limpar($_POST['sobrenome']));

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION["ERROR_DATA_OUT"] = "Insira um e-mail válido!";
                    header('Location:' .PROTOCOLO. '://'.PATH.'/accounts/cadastro');
                } else {
                    if(strlen($senha) < 8) {
                        $_SESSION["ERROR_DATA_PASSWORD"] = "A senha deve contem no minimo 8 caracteres";
                        header('Location: '. PROTOCOLO. '://'.PATH.'/accounts/cadastro');
                    } else {
                        if (isset($_POST['radio'])) {
                            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT );
                            $parametro = [
                                ":usuario" => $usuario,
                                ":email" => $email,
                                ":permissao" => "user",
                                ":senha" => $senha,
                                ":nome" => $nome,
                                ":sobrenome" => $sobrenome,
                                ":sexo" => $_POST['radio'],
                                ":foto_perfil" =>'/img/default/default.png'
                            ];
        
                            $this->database->exe_query("INSERT INTO USUARIO(usuario,email,permissao,senha,nome,sobrenome,sexo,foto_perfil) VALUES(:usuario,:email,:permissao,:senha,:nome,:sobrenome,:sexo, :foto_perfil)", $parametro);
                            $_SESSION["CADASTRO_SUCESSO"] = "Cadastro feito com sucesso, faça o login!";
                            header('Location: ' .PROTOCOLO. '://'.PATH.'/accounts/login');
                        } else {
                            $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/accounts/cadastro');
                        }
                    }
                }

               
               
                
            } else {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location:' .PROTOCOLO. '://'.PATH.'/accounts/cadastro');
            }
        } else {
            header("Location:".PROTOCOLO."://".PATH."/error");
        }
    }



    public function validarLogin()
    {
        if ($_POST) {
            if ($_POST['email'] == "" || $_POST['senha'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location:' .PROTOCOLO. '://'.PATH.'/accounts/login');
            } else {
                $email =trim(limpar($_POST['email']));
                $senha =trim(limpar($_POST['senha']));

                $parametro = [
                    ":email" => $email
                ];

                $resultado = $this->database->query("SELECT * FROM USUARIO WHERE email=:email",$parametro);
                
                if (!$resultado) {
                    $_SESSION["ERROR_DATA_OUT"] = "E-mail ou senha esta incorreta";
                    header('Location:' .PROTOCOLO. '://'.PATH.'/accounts/login');
                } else {
                    if (!password_verify($senha,$resultado[0]['senha'])) {
                        $_SESSION["ERROR_DATA_OUT"] = "E-mail ou senha esta incorreta";
                        header('Location:' .PROTOCOLO. '://'.PATH.'/accounts/login');
                    } else {
                        $_SESSION['user'] = $resultado[0]['id_usuario'];
                        $_SESSION['usuario'] = $resultado[0]['usuario'];
                        $_SESSION['nome_full'] = $resultado[0]['nome'] . " ". $resultado[0]['sobrenome'];
                        $_SESSION['permissao'] = $resultado[0]['permissao'];
                        header('Location:' .PROTOCOLO. '://'.PATH.'/u/profile/'.$_SESSION['usuario'].'');
                    }
                }
            }
        } else {
            header("Location:".PROTOCOLO."://".PATH."/error");
        }


    

    }

    public function logout()
    {
       if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['usuario']);
            unset($_SESSION['nome_full']);
            unset($_SESSION['permissao']);  
            header('Location:' .PROTOCOLO. '://'.PATH.'');
       } else {
         header("Location:".PROTOCOLO."://".PATH."/error");
       }
    }



}
