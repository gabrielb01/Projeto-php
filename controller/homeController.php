<?php 

class HomeController 

{
    function index()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/home.php";


        require_once "view/footer.php";
    }
}





?>