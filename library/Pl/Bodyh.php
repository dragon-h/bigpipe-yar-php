<?php
class Pl_Bodyh{
    public $tpl = 'pl/contentheader.phtml';
    public $children = array();
    public $data = array();
    public $id = 'bodyh';
     
    public function __construct(){
        $this->get_own_data();
        $this->get_children();
    }
     
    public function get_own_data(){}
     
    public function get_children(){
    }
    
}