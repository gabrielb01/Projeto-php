<?php

if (!defined('INDEX')) {
  die("Erro no sistema!");
}

class ErrorController
{
    public $title;

    public $style;
    
    public function index()
    {
        $this->view = new View("error");
        $this->view->render("Erro",$this->style);
    }

  
}


?>