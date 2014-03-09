<?php
class AbstractController{
    protected $tpl = 'index.phtml';
    protected $render;
    
    public function __construct(){
        $this->render = new Render_Remote();
    }
}