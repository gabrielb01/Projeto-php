<?php

class CategoriaController
{
    function index()
     {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/categoria.php";


        require_once "view/footer.php";
    }


    function new()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/novaCategoria.php";


        require_once "view/footer.php";   
    }
}




?>