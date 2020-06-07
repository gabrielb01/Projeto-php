<?php

class ErrorController
{
    private $title;

    private $style;
    
    public function __construct()
    {
        require_once "view/head.php";

        require_once "view/error.php";

        require_once "view/footer.php";
    }

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
        $this->style = $style;
    }

    public function getStyle()
    {
        return $this->style;
    }
}


?>