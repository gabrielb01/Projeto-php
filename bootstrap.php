<?php


Class Bootstrap
{

    
    function __construct($url)
    {

        if ($url == "") {
            require_once("./controller/homeController.php");
            $controller = new HomeController();
            $controller->index();
        } else {
            if (file_exists("./controller/" . $url[0]. "Controller.php")) {
                require_once "./controller/" . $url[0]. "Controller.php";
                $controller = $url[0]."Controller";
                $controller = new $controller();
                if(!isset($url[1])) {
                    $controller->index();
                 } else {
                    $acao = $url[1];
                    if (!isset($url[2])) {
                        $controller->$acao();
                    } else {
                        $controller->$acao($url[2]);
                    }
                }
            } else {
                new ErrorController();
            }
        }
    }
}


?>
