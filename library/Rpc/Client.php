<?php
class Rpc_Client{
    private $uri;
    
    public function __construct($uri){
        $this->uri = $uri;
    }
    
    public function __call($method, $params){
        return Rpc_Transport::call($this->uri, Rpc_Protocol::client_pack($method, $params));
    }
    
    
}