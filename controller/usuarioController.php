<?php

class UsuarioController
{

    function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' .PROTOCOLO. '://'.PATH.'/autenticacao/login');
        }
    }
    function profile() 
    {

        $database = new Database();

        $dados = $database->query("SELECT * FROM USUARIO WHERE id_usuario = :id", [":id" => $_SESSION['user']]);
        
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/profile.php";


        require_once "view/footer.php";
    }


    function edit($acao) 
    {
        
        $database = new Database();

        $dados = $database->query("SELECT * FROM USUARIO WHERE id_usuario = :id", [":id" => $_SESSION['user']]);
        
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/editprofile.php";


        require_once "view/footer.php";
    }

    function editarDadosUsuario()
    {
        if($_POST) {
            $database = new Database();
            if($_POST['form']=="formFullName") {
                if($_POST['nome'] != "" && $_POST['sobrenome'] != "") {
                    
                    $parametro = [
                        ":nome" => $_POST['nome'],
                        ":sobrenome" => $_POST['sobrenome'],
                        ":id" => $_SESSION['user']
                    ];
                    $database->exe_query("UPDATE USUARIO SET nome=:nome,sobrenome=:sobrenome WHERE id_usuario=:id", $parametro);

                    $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-perfil');

                } else {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-usuario');
                }
            } else if($_POST['form'] =="usuario_c") {
                if ($_POST['usuario'] =="") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-usuario');
                } else {
                    if ($_POST['usuario'] ==$_SESSION['usuario']) {
                        $_SESSION["ERROR_DATA_OUT"] = "Você colocou o mesmo nome de usuário!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-usuario');
                    } else {
                        $parametro = [
                            ":usuario" =>$_POST['usuario'],
                            ":id" => $_SESSION['user']
                        ];
                        $resultado = $database->query("SELECT usuario FROM USUARIO WHERE usuario=:usuario AND id_usuario!=:id", $parametro);
                        if (count($resultado) == 0) {
                            $parametro = [
                                ":usuario" => $_POST['usuario'],
                                ":id" => $_SESSION['user']
                            ];
                            $database->exe_query("UPDATE USUARIO SET usuario=:usuario WHERE id_usuario=:id", $parametro);
                            $_SESSION['usuario'] = $_POST['usuario'];
                            $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-usuario');
                        }
                    }
                }
            } else if ($_POST['form'] =="email_c") {
                if ($_POST['email'] =="") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-email');
                } else {

                    $parametro = [
                        ":email" => $_POST['email']
                    ];

                    $resultado = $database->query("SELECT email FROM USUARIO WHERE email=:email", $parametro);
                    if (count($resultado)!=0) {
                        if ($_POST["email"] == $resultado[0]['email']) {
                            $_SESSION["ERROR_DATA_OUT"] = "Você colocou o mesmo nome de usuário!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-email');
                        } else {
                            $_SESSION["ERROR_DATA_OUT"] = "Este email não está disponível, escolha outro!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-email');
                        }
                    } else {
                        $parametro = [
                            ":email" => $_POST['email'],
                            ":id" => $_SESSION['user']
                        ];
                        $database->exe_query("UPDATE USUARIO SET email=:email WHERE id_usuario=:id", $parametro);
                        $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-email');
                    }
                    
                }
            } else if ($_POST['form']=="senha_c") {
                if($_POST['senha'] == "" && $_POST['senha2'] == "" && $_POST['senha_original'] == "") {
                    $_SESSION["ERROR_DATA_OUT"] = "Nenhum Campo pode ficar em branco!";
                    header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-senha');
                 } else {
                     if ($_POST['senha'] != $_POST['senha2']) {
                        $_SESSION["ERROR_DATA_OUT"] = "Você deve escrever a nova senha iguais nos campos!";
                        header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-senha');
                     } else {
                         $parametro = [
                             ":id" => $_SESSION['user']
                         ];
                         $resultado =$database->query("SELECT senha FROM USUARIO WHERE id_usuario=:id",$parametro);

                         if (!password_verify($_POST['senha_original'],$resultado[0]['senha'])) {
                            $_SESSION["ERROR_DATA_OUT"] = "A sua senha está errada [primeiro campo]!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-senha');
                         } else {
                            $parametro = [
                                ":senha" => password_hash($_POST['senha'], PASSWORD_DEFAULT),
                                ":id" => $_SESSION['user']
                            ];
                            $database->exe_query("UPDATE USUARIO SET senha=:senha WHERE id_usuario=:id", $parametro);
                            $_SESSION["EDIT_SUCCESS"] = "Tudo foi salvo!";
                            header('Location: '.PROTOCOLO. '://'.PATH.'/usuario/edit/editar-senha');
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


?>