<?php
class Rpc_Protocol{
    
    /**
     * 格式:
     * array(
     *     'm' => 'foo',  //method,调用的函数
     *     'p' => array(),//params,调用函数的参数
     * ) 
     */
    
    public static function client_pack($method, $params){
        $info = array(
                        'm' => $method,
                        'p' => $params,
        );
        return serialize($info);
    }
    public static function server_unpack($info){
        return unserialize($info);        
    }
    
    /**
     * 格式：
     * array(
     *     'r'   => array(),//result,执行结果
     *     'f'   => true,   //flag,执行是否正常
     * )
     */
    public static function server_pack($result, $flag){
        $info = array(
                        'r' => $result,
                        'f' => $flag,
        );
        return serialize($info);    
    }
    public static function client_unpack($info){
        return unserialize($info);
    }   
}