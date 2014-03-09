<?php
class Rpc_Transport{
    
    /**
     * 串行调用实现
     */
    public static function  call($url, $pack){
        $ch = self::initcurl($url, $pack);
        $content = curl_exec($ch);
        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200){
            return Rpc_Protocol::client_unpack($content);
        }else{
            throw Exception("Error: rpc call fail!");
        }
    }
    
    
    /**
     * 并行调用实现
     */
    public static function concurrent_call($tasks, $df_callback, $df_err_callback){
        if(empty($tasks)) return;
        //初始化curl_multi
        $client = array();
        $mch = curl_multi_init();
        foreach ($tasks as $task){
            if(empty($task['callback']) && empty($df_callback)){
                throw Exception('an callback is necessary! error task:'.http_build_query($task));
            }
            $ch = self::initcurl($task['url'], Rpc_Protocol::client_pack($task['method'], $task['params']));
            curl_multi_add_handle($mch, $ch);
            $client[intval($ch)] = $task;
        }
        //执行请求，并执行一次回调(不能保证请求全部发出去了？？)
        while (curl_multi_exec($mch, $active) === CURLM_CALL_MULTI_PERFORM){}
        if($df_callback){
            call_user_func($df_callback, null);
        }
        //并行处理
        do{
            while(curl_multi_exec($mch, $active) === CURLM_CALL_MULTI_PERFORM) {}
            while( $rt = curl_multi_info_read($mch)){
                $ch = $rt['handle'];
                $info = curl_getinfo($ch);
                $result = Rpc_Protocol::client_unpack(curl_multi_getcontent($ch));
                if(curl_error($ch) || $rt['result'] !== CURLE_OK || $info['http_code'] != 200 || $result['f'] === false){
                    //失败回调
                    $err_callback = $client[intval($ch)]['err_callback'] ? $client[intval($ch)]['err_callback'] : $df_err_callback;
                    if($err_callback){
                        call_user_func($err_callback, $result['r']);
                    }
                    //移除任务
                    curl_multi_remove_handle($mch, $ch);
                    curl_close($ch);
                    unset($client[intval($ch)]);
                    continue;
                }
                //成功回调
                $callback = $client[intval($ch)]['callback'] ? $client[intval($ch)]['callback'] : $df_callback;
                call_user_func($callback, $result['r']);
                //移除任务
                curl_multi_remove_handle($mch, $ch);
                curl_close($ch);
                unset($client[intval($ch)]);
            }
            curl_multi_select($mch);
        }while ($active > 0);
        curl_multi_close($mch);   
    }
    
    /**
     * 初始化curl
     */
    public static function initcurl($url, $data){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        return $ch;
    }
    
}