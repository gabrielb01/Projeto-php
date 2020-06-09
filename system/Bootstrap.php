<?php


Class Bootstrap
{

    
    function __construct($url)
    {

        if ($url == "") {
            $controller = new HomeController();
            $controller->title ="Conscious Vegan";
            $controller->style ='home';
            $controller->index();
        } else {
            $url[0]= ucfirst($url[0]);
            if (file_exists("./controller/" . $url[0]. "Controller.php")) {
                $controller = $url[0]."Controller";
                $controller = new $controller();
                $controller->title =ucfirst($url[0]);
                $controller->style = $url[0];
                if(!isset($url[1])) {
                    $controller->index();
                 } else {
                    $acao = $url[1];
                    if (method_exists($controller,$acao)) {
                        if (!isset($url[2])) {
                            $controller->$acao();
                        } else {
                            $controller->$acao($url[2]);
                        }
                    } else {
                        header("Location:".PROTOCOLO."://".PATH."/error");
                    }
                }
            } else {
                header("Location:".PROTOCOLO."://".PATH."/error");
            }
        }
    }
}


?>
