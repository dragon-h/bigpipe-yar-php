<?php
class Rpc_ConcurrentClient{
    
    private static $task = array();
    
    //加入到发送列表
    public static function call($url, $method, $params = array(), $callback = array(), $err_callback = array()){  
        if($callback && is_callable($callback) == false){
            throw Exception('callback is not exists!');
        }
        if($callback && is_callable($err_callback) == false){
            throw Exception('err_callback is not exists!');
        } 
        self::$task[] = array(
                        'url' => $url,
                        'method' => $method,
                        'params' => $params,
                        'callback' => $callback,
                        'err_callback' => $err_callback,
        );
    }
    
    //执行
    public static function loop($callback = array(), $err_callback = array()){
        if($callback && is_callable($callback) == false){
            throw Exception('callback is not exists!');
        }
        if($err_callback && is_callable($err_callback) == false){
            throw Exception('err_callback is not exists!');
        }
        Rpc_Transport::concurrent_call(self::$task, $callback, $err_callback);
        self::$task = array();
    }
        
}