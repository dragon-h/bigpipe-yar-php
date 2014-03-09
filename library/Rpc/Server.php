<?php
class Rpc_Server{
    public $object = null;
    
    public function __construct($object){
        if(!is_object($object)) throw Exception('param must be an object');
        $this->object = $object;
    }
    
    public function handle(){
        $raw_data = file_get_contents("php://input");
        $post = Rpc_Protocol::server_unpack($raw_data);
        $method = $post['m'];
        $params = $post['p'];
        
        if(!method_exists($this->object, $method)){
            echo Rpc_Protocol::server_pack('Error:Call to undefined API!', false);
        }
        
        try{
            $result = call_user_func_array(array($this->object, $method), $params);
            echo Rpc_Protocol::server_pack($result, true);
        }catch (Exception $e){
            echo Rpc_Protocol::server_pack('Error:'.$e->getMessage(), false);
        }
    }
    
}