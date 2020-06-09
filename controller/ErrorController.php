<?php

class ErrorController
{
    public $title;

    public $style;
    
    public function index()
    {
        $this->view = new View("error");
        $this->view->render($this->title,$this->style);
    }

  
}


?>