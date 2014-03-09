<?php
class Pl_Header{
    public $tpl = 'pl/header.phtml';
    public $children = array();
    public $data = array();
    public $id = 'header';
     
    public function __construct(){
        $this->get_own_data();
        $this->get_children();
    }
     
    public function get_own_data(){}
     
    public function get_children(){
    }
     
    
}