<?php
class HomeController extends AbstractController{
    
    
    
    public function indexAction(){ 

//         $client = new Rpc_Client("http://rpc.my.com");
//         var_dump($client->foo());exit;

//         $url = "http://rpc.my.com";
//         Rpc_ConcurrentClient::call($url, 'foo', array(1));
//         Rpc_ConcurrentClient::call($url, 'foo', array(2));
//         Rpc_ConcurrentClient::call($url, 'foo', array(3));
//         Rpc_ConcurrentClient::loop(array(new Render_Test(),'back'));
//         exit;
        
        
        
        
        $page = new Page_Home();
//         $this->render->render($page);
        $this->render->render($page);
//         $this->render->debug();
    }
    
    
}