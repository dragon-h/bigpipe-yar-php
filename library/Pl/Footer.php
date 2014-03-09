<?php
class Pl_Footer{
    public $tpl = 'pl/footer.phtml';
    public $children = array();
    public $data = array();
    public $id = 'footer';
     
    public function __construct(){
        $this->get_own_data();
        $this->get_children();
    }
     
    public function get_own_data(){}
     
    public function get_children(){
    }
}