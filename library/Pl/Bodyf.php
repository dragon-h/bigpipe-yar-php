<?php
class Pl_Bodyf{
    public $tpl = 'pl/contentfooter.phtml';
    public $children = array();
    public $data = array();
    public $id = 'bodyf';
     
    public function __construct(){
        $this->get_own_data();
        $this->get_children();
    }
     
    public function get_own_data(){}
     
    public function get_children(){
    }
}