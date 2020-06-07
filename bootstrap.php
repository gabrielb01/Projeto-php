<?php


Class Bootstrap
{

    
    function __construct($url)
    {

        if ($url == "") {
            require_once("./controller/homeController.php");
            $controller = new HomeController();
            $controller->setTitle("Conscious Vegan");
            $controller->index();
        } else {
            if (file_exists("./controller/" . $url[0]. "Controller.php")) {
                require_once "./controller/" . $url[0]. "Controller.php";
                $controller = $url[0]."Controller";
                $controller = new $controller();
                $controller->setTitle(ucfirst($url[0]));
                $controller->setStyle($url[0]);
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
                        new ErrorController();
                    }
                }
            } else {
                new ErrorController();
            }
        }
    }
}


?>
