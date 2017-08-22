<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_GAOSOU') or exit('Access Denied');
class dcache {
	var $pre;

    function dcache() {
		//
    }

    function get($key) {
        return apc_fetch($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
        return apc_store($this->pre.$key, $val, $ttl);
    }

    function rm($key) {
        return apc_delete($this->pre.$key);
    }

    function clear() {
        return apc_clear_cache();
    }

	function expire() {
		return true;
	}
}
?>