<?php


Class AutenticacaoController
{


     function __construct()
    {
        if (isset($_SESSION['user'])) {
            header('Location:' .PROTOCOLO. '://'.PATH.'');
        }
    }

    function login()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/login.php";


        require_once "./view/footer.php";
    }

    function cadastro()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/cadastro.php";


        require_once "view/footer.php";
        
    }

    function validarCadastro() 
    {


        $database = new Database();
        if ($_POST){


            if ($_POST['email'] != "" && $_POST['senha'] && $_POST['usuario'] != "" && $_POST['nome'] !="" && $_POST['sobrenome']) {
             

                if(strlen($_POST['senha']) < 8) {
                    $_SESSION["ERROR_DATA_PASSWORD"] = "A senha deve contem no minimo 8 caracteres";
                    header('Location: '. PROTOCOLO. '://'.PATH.'/autenticacao/cadastro');
                } else {
                    if (isset($_POST['radio'])) {
                        $number = strval(rand(1,100000));
                        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT );
                        $usuario = $_POST['usuario'];
                        $parametro = [
                            ":usuario" => $usuario,
                            ":email" => $_POST['email'],
                            ":permissao" => "user",
                            ":senha" => $senha,
                            ":nome" => $_POST['nome'],
                            ":sobrenome" => $_POST['sobrenome'],
                            ":sexo" => $_POST['radio'],
                            ":foto_perfil" =>  PROTOCOLO. '://'.PATH.'/img/default/default.png' 
                        ];
    
                        $database->exe_query("INSERT INTO USUARIO(usuario,email,permissao,senha,nome,sobrenome,sexo,foto_perfil) VALUES(:usuario,:email,:permissao,:senha,:nome,:sobrenome,:sexo, :foto_perfil)", $parametro);
                        $_SESSION["CADASTRO_SUCESSO"] = "Cadastro feito com sucesso, faça o login!";
                        header('Location: ' .PROTOCOLO. '://'.PATH.'/autenticacao/login');
                    } else {
                        $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/autenticacao/cadastro');
                    }
                }
               
                
            } else {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location:' .PROTOCOLO. '://'.PATH.'/autenticacao/cadastro');
            }
        } else {
            new ErrorController();
        }
    }



    function validarLogin()
    {
        if ($_POST) {
            if ($_POST['email'] == "" || $_POST['senha'] == "") {
                $_SESSION["ERROR_DATA_OUT"] = "insira todos os dados";
                header('Location:' .PROTOCOLO. '://'.PATH.'/autenticacao/login');
            } else {
                $database = new Database();

                $parametro = [
                    ":email" => $_POST['email']
                ];

                $resultado = $database->query("SELECT * FROM USUARIO WHERE email=:email",$parametro);
                
                if (!$resultado) {
                    $_SESSION["ERROR_DATA_LOGIN"] = "Email ou senha está incorretos";
                    header('Location:' .PROTOCOLO. '://'.PATH.'/autenticacao/login');
                } else {
                    if (!password_verify($_POST['senha'],$resultado[0]['senha'])) {
                        $_SESSION["ERROR_DATA_LOGIN"] = "Email ou, a senha está incorreto";
                        header('Location:' .PROTOCOLO. '://'.PATH.'/autenticacao/login');
                    } else {
                        $_SESSION['user'] = $resultado[0]['id_usuario'];
                        $_SESSION['usuario'] = $resultado[0]['usuario'];
                        $_SESSION['nome_full'] = $resultado[0]['nome'] . " ". $resultado[0]['sobrenome'];
                        $_SESSION['permissao'] = $resultado[0]['permissao'];
                        header('Location:' .PROTOCOLO. '://'.PATH.'/usuario/profile/'.$_SESSION['usuario'].'');
                    }
                }
            }
        } else {
            new ErrorController();
        }


    

    }

    function logout()
    {
       if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['usuario']);
            unset($_SESSION['nome_full']);
            unset($_SESSION['permissao']);  
            header('Location:' .PROTOCOLO. '://'.PATH.'');
       } else {
            new ErrorController();
       }
    }



}



?>