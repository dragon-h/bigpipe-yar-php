<?php
class Page_Abstract{
    protected $tpl = 'index.phtml';
    
    protected function get_tpl(){
        return $this->tpl;
    }
    
}