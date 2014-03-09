<?php
//rpc调用访问入口

//autoload 设置
function autoload($classname){
    $dirname=str_replace('_', '/', $classname);
    $library_name = '../library/'.$dirname.'.php';
    $controller_name = '../controllers/'.str_replace('Controller','',$dirname).'.php';
    if(file_exists($library_name)){
        require_once($library_name);
    }elseif(file_exists($controller_name)){
        require_once($controller_name);
    }
}
spl_autoload_register('autoload');

//RPC Server 
$server = new Rpc_Server(new Render_Remote());
$server->handle();

