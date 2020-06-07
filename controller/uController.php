<?php
// classe usuário
class UController
{

    private $title;
    private $style;

    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' .PROTOCOLO. '://'.PATH.'/accounts/login');
        }

        $this->setTitle($_SESSION['nome_full']);
    }

    function setTitle($title)
    {
        $this->title =$title;
    }

    function getTitle()
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
    public function profile() 
    {

        $database = new Database();

        $dados = $database->query("SELECT * FROM USUARIO WHERE id_usuario = :id", [":id" => $_SESSION['user']]);

        $this->title = $_SESSION['nome_full'];
        
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/usuario/profile.php";


        require_once "view/footer.php";
    }


    public function edit($acao) 
    {
        $this->setTitle($_SESSION['nome_full']);
        
        $database = new Database();

        $dados = $database->query("SELECT * FROM USUARIO WHERE id_usuario = :id", [":id" => $_SESSION['user']]);
        
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/usuario/editprofile.php";


        require_once "view/footer.php";
    }

    public function editarDadosUsuario()
    {
        if($_POST) {
            $database = new Database();
            if($_POST['form']=="formFullName") {
                if($_POST['nome'] != "" && $_POST['sobrenome'] != "") {
                    
                    $nome =trim(limpar($_POST['nome']));
                    $sobrenome =trim(limpar($_POST['sobrenome']));

                    $parametro = [
                        ":nome" => $nome,
                        ":sobrenome" => $sobrenome,
                        ":id" => $_SESSION['user']
                    ];
                    $database->exe_query("UPDATE USUARIO SET nome=:nome,sobrenome=:sobrenome WHERE id_usuario=:id", $parametro);

                    $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-perfil');

                } else {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-usuario');
                }
            } else if($_POST['form'] =="usuario_c") {
                if ($_POST['usuario'] =="") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-usuario');
                } else {
                    $usuario =trim(limpar($_POST['usuario']));
                    if ($usuario ==$_SESSION['usuario']) {
                        $_SESSION["ERROR_DATA_OUT"] = "Você colocou o mesmo nome de usuário!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-usuario');
                    } else {
                        $parametro = [
                            ":usuario" =>$usuario,
                            ":id" => $_SESSION['user']
                        ];
                        $resultado = $database->query("SELECT usuario FROM USUARIO WHERE usuario=:usuario AND id_usuario!=:id", $parametro);
                        if (count($resultado) == 0) {
                            $parametro = [
                                ":usuario" => $usuario,
                                ":id" => $_SESSION['user']
                            ];
                            $database->exe_query("UPDATE USUARIO SET usuario=:usuario WHERE id_usuario=:id", $parametro);
                            $_SESSION['usuario'] = $_POST['usuario'];
                            $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-usuario');
                        }
                    }
                }
            } else if ($_POST['form'] =="email_c") {
                if ($_POST['email'] =="") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-email');
                } else {
                    $email =trim(limpar($_POST['email']));
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION["ERROR_DATA_OUT"] = "Insira um e-mail válido!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-email');
                    } else {

                    $parametro = [
                        ":email" => $email
                    ];

                    $resultado = $database->query("SELECT email FROM USUARIO WHERE email=:email", $parametro);
                    if (count($resultado)!=0) {
                        if ($email == $resultado[0]['email']) {
                            $_SESSION["ERROR_DATA_OUT"] = "Você colocou o mesmo nome de usuário!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-email');
                        } else {
                            $_SESSION["ERROR_DATA_OUT"] = "Este email não está disponível, escolha outro!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-email');
                        }
                    } else {
                        $parametro = [
                            ":email" => $email,
                            ":id" => $_SESSION['user']
                        ];
                        $database->exe_query("UPDATE USUARIO SET email=:email WHERE id_usuario=:id", $parametro);
                        $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-email');
                    }
                    }

                    
                }
            } else if ($_POST['form']=="senha_c") {
                if($_POST['senha'] == "" && $_POST['senha2'] == "" && $_POST['senha_original'] == "") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-senha');
                 } else {
                    $senha =trim(limpar($_POST['senha']));
                    $senha2 =trim(limpar($_POST['senha2']));
                    $senha_original =trim(limpar($_POST['senha_original']));
                     if ($senha != $senha2) {
                        $_SESSION["ERROR_DATA_OUT"] = "Você deve escrever a nova senha iguais nos campos!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-senha');
                     } else {
                         if(strlen($senha) <8) {
                            $_SESSION["ERROR_DATA_OUT"] = "A senha de contém no mínimo 8 caracteres!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-senha');
                         } else {
                            $parametro = [
                                ":id" => $_SESSION['user']
                            ];
                            $resultado =$database->query("SELECT senha FROM USUARIO WHERE id_usuario=:id",$parametro);
   
                            if (!password_verify($senha_original,$resultado[0]['senha'])) {
                               $_SESSION["ERROR_DATA_OUT"] = "A sua senha está errada [primeiro campo]!";
                               header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-senha');
                            } else {
                               $parametro = [
                                   ":senha" => password_hash($senha, PASSWORD_DEFAULT),
                                   ":id" => $_SESSION['user']
                               ];
                               $database->exe_query("UPDATE USUARIO SET senha=:senha WHERE id_usuario=:id", $parametro);
                               $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                               header('Location: '.PROTOCOLO. '://'.PATH.'/u/edit/editar-senha');
                            }
                         }
                     }
                 }
            } else if ($_POST['form']=="excluir") {
                $parametro = [
                    ":id" => $_SESSION['user']
                ];
                $database->exe_query("DELETE FROM USUARIO WHERE id_usuario=:id",$parametro);
                $_SESSION["EDIT_SUCCESS"] = "Sua conta foi excluída!";
                unset($_SESSION['user']);
                unset($_SESSION['usuario']);
                unset($_SESSION['nome_full']);
                header('Location:' .PROTOCOLO. '://'.PATH.'');

            }
        } else {
            new ErrorCOntroller();
        }
    }
}
