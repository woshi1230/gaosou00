<?php 
defined('IN_GAOSOU') or exit('Access Denied');
class brand {
	var $moduleid;
	var $task_id;
	var $db;
	var $table;
	var $table_data;
	var $split;
	var $fields;
	var $errmsg = errmsg;

    function brand($moduleid) {
		global $db, $table, $table_data, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->table_data = $table_data;
		$this->split = $MOD['split'];
		$this->db = &$db;
		//$this->fields = array('catid','level','title','style','fee','introduce','areaid','thumb','homepage','status','hits','username','addtime','adddate','editor','edittime','editdate','ip','template', 'linkurl','filepath','note','company','truename','telephone','mobile','address','email','msn','qq','ali','skype');
		//$this->fields = array('catid','task_title','fee','introduce','area','task_pic','status','hits','username','adddate','editor','edittime','editdate','ip','template', 'linkurl','filepath','msn', 'skype');
		$this->fields = array('catid','task_title','area','task_pic','stask_status','view_num','username','start_time','sub_time','end_time','sp_end_time', 'trust_type');
    }

	function pass($post) {
		global $DT_TIME, $MOD;
		if(!is_array($post)) return false;
		if(!$post['catid']) return $this->_(lang('message->pass_catid'));
		if(strlen($post['title']) < 3) return $this->_(lang('message->pass_title'));
		if(!is_url($post['thumb'])) return $this->_(lang('message->pass_logo'));
		if(DT_MAX_LEN && strlen($post['content']) > DT_MAX_LEN) return $this->_(lang('message->pass_max'));
		return true;
	}

	function set($post) {
		global $MOD, $DT_TIME, $DT_IP, $_username, $_userid;
		$post['filepath'] = (isset($post['filepath']) && is_filepath($post['filepath'])) ? file_vname($post['filepath']) : '';
		$post['editor'] = $_username;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $DT_TIME;
		$post['adddate'] = timetodate($post['addtime'], 3);
		$post['edittime'] = $DT_TIME;
		$post['editdate'] = timetodate($post['edittime'], 3);
		$post['fee'] = dround($post['fee']);
		$post['homepage'] = fix_link($post['homepage']);
		$post['video'] = fix_link($post['video']);
		$post['video_width'] = intval($post['video_width']);
		$post['video_height'] = intval($post['video_height']);
		$post['content'] = stripslashes($post['content']);
		$post['content'] = save_local($post['content']);
		if($MOD['clear_link']) $post['content'] = clear_link($post['content']);
		if($MOD['save_remotepic']) $post['content'] = save_remote($post['content']);
		if($MOD['introduce_length']) $post['introduce'] = addslashes(get_intro($post['content'], $MOD['introduce_length']));
		if($this->task_id) {
			$new = $post['content'];
			if($post['thumb']) $new .= '<img src="'.$post['thumb'].'"/>';
			$r = $this->get_one();
			$old = $r['content'];
			if($r['thumb']) $old .= '<img src="'.$r['thumb'].'"/>';
			delete_diff($new, $old);
		} else {
			$post['ip'] = $DT_IP;
		}
		$content = $post['content'];
		unset($post['content']);
		$post = dhtmlspecialchars($post);
		$post['content'] = addslashes(dsafe($content));
		return array_map("trim", $post);
	}

	function get_one() {
		$r = $this->db->get_one("SELECT * FROM {$this->table} WHERE task_id=$this->task_id");
//		if($r) {
//			$content_table = content_table($this->moduleid, $this->task_id, $this->split, $this->table_data);
//			//$t = $this->db->get_one("SELECT content FROM {$content_table} WHERE task_id=$this->task_id");
//			$t = $this->db->get_one("SELECT content FROM {$content_table} WHERE task_id=$this->task_id");
//			$r['content'] = $t ? $t['content'] : '';
//			return $r;
//		} else {
//			return array();
//		}
	}

	function get_list($condition = 'status=3', $order = 'edittime DESC', $cache = '') {
		global $MOD, $pages, $page, $pagesize, $offset, $items, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition", $cache);
			$items = $r['num'];
		}
		$pages = defined('CATID') ? listpages(1, CATID, $items, $page, $pagesize, 10, $MOD['linkurl']) : pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = $catids = $CATS = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize", $cache);
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['todate'] = timetodate($r['totime'], 3);
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$catids[$r['catid']] = $r['catid'];
			$lists[] = $r;
		}
		if($catids) {
			$result = $this->db->query("SELECT catid,catname,linkurl FROM yw_category WHERE catid IN (".implode(',', $catids).")");
			while($r = $this->db->fetch_array($result)) {
				$CATS[$r['catid']] = $r;
			}
			if($CATS) {
				foreach($lists as $k=>$v) {
					$lists[$k]['catname'] = $v['catid'] ? $CATS[$v['catid']]['catname'] : '';
					$lists[$k]['caturl'] = $v['catid'] ? $MOD['linkurl'].$CATS[$v['catid']]['linkurl'] : '';
				}
			}
		}
		return $lists;
	}

	function add($post) {
		global $MOD;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			//if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
			if($moduleid=88){
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->task_id = $this->db->insert_id();
		$content_table = content_table($this->moduleid, $this->task_id, $this->split, $this->table_data);
		$this->db->query("REPLACE INTO {$content_table} (task_id,content) VALUES ('$this->task_id', '$post[content]')");
		$this->update($this->task_id);
		if($post['status'] == 3 && $post['username'] && $MOD['credit_add']) {
			credit_add($post['username'], $MOD['credit_add']);
			credit_record($post['username'], $MOD['credit_add'], 'system', lang('my->credit_record_add', array($MOD['name'])), 'ID:'.$this->task_id);
		}
		clear_upload($post['content'].$post['thumb'], $this->task_id);
		return $this->task_id;
	}

	function edit($post) {
		$this->delete($this->task_id, false);
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			 $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE task_id=$this->task_id");
		$content_table = content_table($this->moduleid, $this->task_id, $this->split, $this->table_data);
		$this->db->query("REPLACE INTO {$content_table} (task_id,content) VALUES ('$this->task_id', '$post[content]')");
		$this->update($this->task_id);
		clear_upload($post['content'].$post['thumb'], $this->task_id);
		if($post['status'] > 2) $this->tohtml($this->task_id, $post['catid']);
		return true;
	}

	function tohtml($task_id = 0, $catid = 0) {
		global $module, $MOD;
		if($MOD['show_html'] && $task_id) tohtml('show', $module, "task_id=$task_id");
	}

	function update($task_id) {
		$item = $this->db->get_one("SELECT * FROM {$this->table} WHERE task_id=$task_id");
		$update = '';
		//$keyword = $item['title'].','.$item['company'].','.strip_tags(cat_pos(get_cat($item['catid']), ',')).strip_tags(area_pos($item['areaid'], ','));
		$keyword = $item['task_title'].','.strip_tags(cat_pos(get_cat($item['catid']), ',')).strip_tags(area_pos($item['area'], ','));
		if($keyword != $item['keyword']) {
			$keyword = str_replace("//", '', addslashes($keyword));
			$update .= ",keyword='$keyword'";
		}
		$item['task_id'] = $task_id;
		$linkurl = itemurl($item);
		if($linkurl != $item['linkurl']) $update .= ",linkurl='$linkurl'";
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($member) $update .= update_user($member, $item);
		if($update) $this->db->query("UPDATE {$this->table} SET ".(substr($update, 1))." WHERE task_id=$task_id");
	}

	function recycle($task_id) {
		if(is_array($task_id)) {
			foreach($task_id as $v) { $this->recycle($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=0 WHERE task_id=$task_id");
			$this->delete($task_id, false);
			return true;
		}		
	}

	function restore($task_id) {
		global $module, $MOD;
		if(is_array($task_id)) {
			foreach($task_id as $v) { $this->restore($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=3 WHERE task_id=$task_id");
			if($MOD['show_html']) tohtml('show', $module, "task_id=$task_id");
			return true;
		}		
	}

	function delete($task_id, $all = true) {
		global $MOD;
		if(is_array($task_id)) {
			foreach($task_id as $v) { 
				$this->delete($v, $all);
			}
		} else {
			$this->task_id = $task_id;
			$r = $this->get_one();
			if($MOD['show_html']) {
				$_file = DT_ROOT.'/'.$MOD['moduledir'].'/'.$r['linkurl'];
				if(is_file($_file)) unlink($_file);
			}
			if($all) {
				$userid = get_user($r['username']);
				if($r['thumb']) delete_upload($r['thumb'], $userid);
				if($r['content']) delete_local($r['content'], $userid);
				$this->db->query("DELETE FROM {$this->table} WHERE task_id=$task_id");
				$content_table = content_table($this->moduleid, $this->task_id, $this->split, $this->table_data);
				$this->db->query("DELETE FROM {$content_table} WHERE task_id=$task_id");
				if($MOD['cat_property']) $this->db->query("DELETE FROM {$this->db->pre}category_value WHERE moduleid=$this->moduleid AND task_id=$task_id");
				if($r['username'] && $MOD['credit_del']) {
					credit_add($r['username'], -$MOD['credit_del']);
					credit_record($r['username'], -$MOD['credit_del'], 'system', lang('my->credit_record_del', array($MOD['name'])), 'ID:'.$this->task_id);
				}
			}
		}
	}

	function check($task_id) {
		global $_username, $DT_TIME, $MOD;
		if(is_array($task_id)) {
			foreach($task_id as $v) { $this->check($v); }
		} else {
			$this->task_id = $task_id;
			$item = $this->get_one();
			if($MOD['credit_add'] && $item['username'] && $item['hits'] < 1) {
				credit_add($item['username'], $MOD['credit_add']);
				credit_record($item['username'], $MOD['credit_add'], 'system', lang('my->credit_record_add', array($MOD['name'])), 'ID:'.$this->task_id);
			}
			$editdate = timetodate($DT_TIME, 3);
			$this->db->query("UPDATE {$this->table} SET task_status=2,view_num=view_num+1 WHERE task_id=$task_id");
			$this->tohtml($task_id);
			return true;
		}
	}


//	function check($task_id) {
//		global $_username, $DT_TIME, $MOD;
//		if(is_array($task_id)) {
//			foreach($task_id as $v) { $this->check($v); }
//		} else {
//			$this->task_id = $task_id;
//			$item = $this->get_one();
//			if($MOD['credit_add'] && $item['username'] && $item['hits'] < 1) {
//				credit_add($item['username'], $MOD['credit_add']);
//				credit_record($item['username'], $MOD['credit_add'], 'system', lang('my->credit_record_add', array($MOD['name'])), 'ID:'.$this->task_id);
//			}
//			$editdate = timetodate($DT_TIME, 3);
//			$this->db->query("UPDATE {$this->table} SET status=3,hits=hits+1,editor='$_username',edittime=$DT_TIME,editdate='$editdate' WHERE task_id=$task_id");
//			$this->tohtml($task_id);
//			return true;
//		}
//	}


	function reject($task_id) {
		global $_username, $DT_TIME;
		if(is_array($task_id)) {
			foreach($task_id as $v) { $this->reject($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET task_status=10 WHERE task_id=$task_id");
			return true;
		}
	}

	function clear($condition = 'status=0') {		
		$result = $this->db->query("SELECT task_id FROM {$this->table} WHERE $condition");
		while($r = $this->db->fetch_array($result)) {
			$this->delete($r['task_id']);
		}
	}

	function level($task_id, $level) {
		$task_ids = is_array($task_id) ? implode(',', $task_id) : $task_id;
		$this->db->query("UPDATE {$this->table} SET level=$level WHERE task_id IN ($task_ids)");
	}

	function refresh($task_id) {
		global $DT_TIME;
		$editdate = timetodate($DT_TIME, 3);
		$task_ids = is_array($task_id) ? implode(',', $task_id) : $task_id;
		$this->db->query("UPDATE {$this->table} SET edittime='$DT_TIME',editdate='$editdate' WHERE task_id IN ($task_ids)");
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>