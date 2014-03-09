<?php
class Plc_Body{
    public $tpl = 'plc/body.phtml';
    public $children = array();
    public $data = array();
    public $id = 'body';
     
    public function __construct(){
        $this->get_own_data();
        $this->get_children();
    }
     
    public function get_own_data(){}
     
    public function get_children(){
        $this->children[] = new Pl_Bodyh();
        $this->children[] = new Pl_Bodyb();
        $this->children[] = new Pl_Bodyf();
    }
    
}