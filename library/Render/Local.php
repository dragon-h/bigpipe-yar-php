<?php
/**
 * 串行BP渲染
 * @author yunlong3
 *
 */
class Render_Local extends Render_Abstract{
    
    public function render($page){
        //先输出page本身的html代码（骨架）
        $this->output($this->getHtml($page->tpl, $page->data));
        //再分别输出各pl的html代码
        $this->renderChildren($page->children);
    }
        
    /**
     * 中序遍历输出
     * @param unknown $children
     */
    public function renderChildren($children){
        if(empty($children)) return;
        foreach ($children as $child){
            $this->outputAsScript($child->tpl, $child->data, $child->id);
            $this->renderChildren($child->children);
        }
    }
}