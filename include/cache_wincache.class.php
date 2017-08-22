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
		return wincache_ucache_get($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
		return wincache_ucache_set($this->pre.$key, $val, $ttl);
    }

    function rm($key) {
		return wincache_ucache_delete($this->pre.$key);
    }

    function clear() {
        return wincache_ucache_clear();
    }

	function expire() {
		return true;
	}
}
?>