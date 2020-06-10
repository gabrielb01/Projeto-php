<?php

if (!defined('INDEX')) {
  die("Erro no sistema!");
}

class View
{
    private $fileName;
    public static $title;
    public static $style;
  
    

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function render($title,$style)
    {

        self::$title = $title;
        self::$style = $style;
        require_once './view/head.php';
        require_once './view/navegacao.php';
        alert();
        require_once './view/' . $this->fileName . '.php';
        require_once './view/footer.php';
    }

}
