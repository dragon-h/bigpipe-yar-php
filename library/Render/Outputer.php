<?php
/**
 * 脚本输出器
 * 用来判断是否输出script,可以输出的标准为：没有父节点，或者父节点已输出
 * @author yunlong3
 *
 */

class Render_Outputer extends Render_Abstract{
    private $tree = array();//保存整个pl结构
    
    /**
     * 创建根节点
     */
    public function createRoot($id, $flag = true, $script = ''){
        $this->tree[$id] = array(
                        'script' => $script,
                        'children' => array(),
                        'flag' => $flag,
                        'father' => null,
        );
    }
        
    /**
     * 添加子节点
     */
    public function add($id, $father = null){
        $this->tree[$id] = array(
                'script' => '',
                'children' => array(),
                'flag' => false,                      
        ); 
        if($father && $this->tree[$father]){
            $this->tree[$id]['father'] = &$this->tree[$father];
            $this->tree[$father]['children'][$id] = &$this->tree[$id];
        }else{
            $this->tree[$id]['father'] = null;
        }  
    }

    /**
     * 把自己标志为已输出
     */
    public function iAmDone($id){
        $this->tree[$id]['flag'] = true;
    }
    
    /**
     * 尝试输出，如父节点存在且未输出，则只保存不输出
     */
    public function tryMe($id, $script){
        $this->tree[$id]['script'] = $script;
        if(empty($this->tree[$id]['father']) || $this->tree[$id]['father']['flag'] === true){
            $this->outputMeAndChildren($id);
            return;
        }
        error_log('client:'.$id."===no===\n",3,'/tmp/rpc.log');
    }
    
    /**
     * 输出自己，并且输出所有script已获取且未输出的子节点
     * @param unknown $id
     */
    private function outputMeAndChildren($id){
        $this->output($this->tree[$id]['script']);
        $this->iAmDone($id);
        error_log('client:'.$id."\n",3,'/tmp/rpc.log');
        if(empty($this->tree[$id]['children'])) return;
        foreach($this->tree[$id]['children'] as $k => $child){
            if($child['flag'] == false && !empty($child['script'])){
                $this->outputMeAndChildren($k);
            }
        }
    }

    
}