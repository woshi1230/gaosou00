<?php
class imageClass{
    static function absUrl($url){
        global $_K;
        if(!$url){
            return  false;
        }
        if(substr($url, 0, 4) == 'http'){
            return $url;
        }
        if(file_exists(S_ROOT.'/'.$url)){
            return $_K['siteurl'].'/'.$url;
        }
        return false;
    }
}