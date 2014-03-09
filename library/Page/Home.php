<?php
 class Page_Home extends Page_Abstract{
     
     public $tpl = "home.phtml";
     public $children = array();
     public $data = array();
     public $id = 'home';
     
     public function __construct(){
         $this->get_own_data();
         $this->get_children();
     }
     
     public function get_own_data(){}
     
     public function get_children(){
         $this->children[] = new Pl_Header();
         $this->children[] = new Plc_Body();
         $this->children[] = new Pl_Footer();
     }
     
 }