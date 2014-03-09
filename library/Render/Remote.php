<?php
/**
 * RPC并行BP渲染
 * @author yunlong3
 *
 */
class Render_Remote extends Render_Abstract{
    protected $rpc_url = "http://rpc.my.com";
    protected $outputer;
    
    
    public function __construct(){
        $this->outputer = new Render_Outputer();
    }
 
    public function render($page){
        //先输出page本身的html代码（骨架）
        $this->output($this->getHtml($page->tpl, $page->data));
        //rpc并行渲染
        $this->outputer->createRoot($page->id);
        $this->renderChildren($page->id, $page->children);
        Rpc_ConcurrentClient::loop(array($this, 'rpc_outputer'), array($this, 'rpc_error'));
    }
    
    private function renderChildren($id, $children){
        if(empty($children)) return;
        foreach ($children as $child){
            Rpc_ConcurrentClient::call($this->rpc_url, 'rpc_getScript', array($child));
            $this->outputer->add($child->id, $id);
            $this->renderChildren($child->id, $child->children);
        }
    }
    
    
    
    /*****以下为RPC相关方法*****/    
    
    /**
     * rpc回调方法，用来输出渲染好的script
     */
    public function rpc_outputer($result){
        if($result == null){
            //全部请求发完后的回调处理
            error_log('client: all send!'."\n",3,'/tmp/rpc.log');
            return;
        }  
        //当前请求的回调处理      
        $id = $result['id'];
        $script= $result['script'];
        $this->outputer->tryMe($id, $script);        
    }
    
    /**
     * 供rpc错误回调
     */
    public function rpc_error($result){
        error_log('client:'.$result."===error==\n",3,'/tmp/rpc.log');
    }
    
    
    /**
     * rpc调用方法，用来搭建rpc server,供client调用，用来渲染script
     */
    public function rpc_getScript($page){
        if($page->id == 'body') sleep(5);
        $a = $this->getHtml($page->tpl, $page->data);
        $script = $this->getScript($page->id, $a);
        return array('id'=>$page->id, 'script'=>$script);
    }
}