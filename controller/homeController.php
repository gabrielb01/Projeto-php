<?php 

class HomeController 

{
    private $title;

    private $style;


    public function setTitle($title)
    {
        $this->title =$title;
    }

    public function getTitle()
    {
        return $this->title;
    }
    

    public function setStyle($style)
    {
        $this->style=$style;
    }

    public function getStyle()
    {
        return $this->style;
    }

    
    public function index()
    {
        require_once "view/head.php";

        require_once "view/navegacao.php";        

        require_once "view/home/home.php";


        require_once "view/footer.php";
    }

   
}





?>