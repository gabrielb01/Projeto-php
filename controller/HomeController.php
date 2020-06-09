<?php 

class HomeController

{
    public $title;
    public $style;
    

    
    public function index()
    {
        $this->view = new View("home/home");
        $this->view->render($this->title,$this->style);
    }

   
}





?>