<?php
class Render_Abstract{
    
    //output a html as a script
    protected function outputAsScript($tpl, $data, $id){
        $html = "<script>";
        $html .= "FM(\"".$id."\",".json_encode($this->getHtml($tpl, $data)).")";
        $html .="</script>\n";
        echo $html;
        $this->flush();
    }
    
    //output a html/script
    protected function output($htmlOrScript){
        echo $htmlOrScript;
        $this->flush();
    }
    
    //get a script
    protected function getScript($id, $html){
        $script = "<script>";
        $script .= "FM(\"".$id."\",".json_encode($html).")";
        $script .="</script>\n";
        return $script;
    }

    //get html as string
    protected function getHtml($tpl, $data){
        ob_start();
        extract($data);
        $tpl_file = '../tpl/'.$tpl;
        if(is_readable($tpl_file)){
            require($tpl_file);
        }else{
            ob_end_clean();
            throw new Exception('tpl not found!');
        }
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
    
    //flush
    protected function flush(){
        if (ob_get_level()) {
            ob_flush();
        }
        flush();
        return true;
    }
}