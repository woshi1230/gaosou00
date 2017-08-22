<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_GAOSOU') or exit('Access Denied');
class treeNode {
	var $id;
	var $name;
	var $img;
}
class catetree {
	var $arr;
	var $ret;

	function catetree($arr = array()) {
		$this->arr = $arr;

		$root = new treeNode;
		$root->id = 0;
		$root->name = "商品总类";
		$root->img = "";
		$root->children = array();
		$this->ret = $root;
		return is_array($arr);
	}

	function get_parent($myid) {
		$newarr = array();
		if(!isset($this->arr[$myid])) return false;
		$pid = $this->arr[$myid]['parentid'];
		$pid = $this->arr[$pid]['parentid'];
		if(is_array($this->arr)) {
			foreach($this->arr as $id => $a) {
				if($a['parentid'] == $pid) $newarr[$id] = $a;
			}
		}
		return $newarr;
	}

	function get_child($myid) {
		$a = $newarr = array();
		if(is_array($this->arr)) {
			foreach($this->arr as $id => $a) {
				if($a['parentid'] == $myid) $newarr[$id] = $a;
			}
		}
		return $newarr ? $newarr : false;
	}

	function get_pos($myid, &$newarr) {
		$a = array();
		if(!isset($this->arr[$myid])) return false;
        $newarr[] = $this->arr[$myid];
		$pid = $this->arr[$myid]['parentid'];
		if(isset($this->arr[$pid])) $this->get_pos($pid,$newarr);
		if(is_array($newarr)) {
			krsort($newarr);
			foreach($newarr as $v) {
				$a[$v['id']] = $v;
			}
		}
		return $a;
	}

	function get_tree($myid, $rate, $pNode) {
		$child = $this->get_child($myid);
		$rate = round($rate / count($child), 2);
		if(is_array($child)) {
			foreach($child as $id=>$a) {
				$node = new treeNode;
				$node->id = $id;
				$node->ord = $a['ord'];
				$node->name = $a['name'];
				$node->img = $a['img'];
				if ($a['child']) {
					$node->children = array();
				} else {
					$node->size = $rate;
				}
				array_push($pNode->children, $node);

				if ($a['child']) {
					$this->get_tree($id, $rate, $node);
				}
			}
		}
		return $this->ret;
	}
}
?>