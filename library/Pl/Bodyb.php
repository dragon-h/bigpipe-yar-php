<?php
class Pl_Bodyb{
    public $tpl = 'pl/contentbody.phtml';
    public $children = array();
    public $data = array();
    public $id ='bodyb';
     
    public function __construct(){
        $this->get_own_data();
        $this->get_children();
    }
     
    public function get_own_data(){}
     
    public function get_children(){
    }
}