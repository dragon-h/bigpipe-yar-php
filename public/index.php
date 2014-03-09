<?php
//唯一访问入口

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

//controller路由
$uri = $_SERVER['REQUEST_URI'];
$classes = explode('/', trim($uri, '/'));
foreach ($classes as &$class){
    $class = ucfirst($class);
}
$class_name=implode('_', $classes).'Controller';
if(class_exists($class_name)){
    $action = new $class_name();
    $action->indexAction();
}else{
    throw new Exception('controller not found!');
}

