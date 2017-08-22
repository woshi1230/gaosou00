<?php 
defined('IN_GAOSOU') or exit('Access Denied');
class report {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function report() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'witkey_report';
		$this->db = &$db;
		$this->fields = array( 'report_id','obj','obj_id','origin_id','front_status','uid','username','user_type','to_uid','to_username','is_hide','report_desc','report_file','report_status','on_time','report_type','op_uid','op_username','op_result','op_time','phone','qq','report_reason');
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		if(!$post['content']) return $this->_($L['gbook_pass_content']);
		return true;
	}

	function set($post) {
		global $DT_TIME, $_username, $DT_IP, $TYPE;
		$post['content'] = strip_tags($post['content']);
		$post['title'] = in_array($post['type'], $TYPE) ? '['.$post['type'].']' : '';
		$post['title'] .= dsubstr($post['content'], 30);
		$post['title'] = daddslashes($post['title']);
		$post['hidden'] = isset($post['hidden']) ? 1 : 0;
		if($this->itemid) {
			$post['status'] = $post['status'] == 2 ? 2 : 3;
			$post['editor'] = $_username;
			$post['edittime'] = $DT_TIME;
		} else {
			$post['username'] = $_username;
			$post['addtime'] =  $DT_TIME;
			$post['ip'] =  $DT_IP;
			$post['edittime'] = 0;
			$post['reply'] = '';
			$post['status'] = 2;
		}
		$post = dhtmlspecialchars($post);
		return array_map("trim", $post);
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE report_id='$this->itemid'");
	}

	function get_list($condition = 'status=3', $order = 'report_id DESC') {
		global $MOD, $pages, $page, $pagesize, $offset, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['on_time'], 5);
			$r['report_desc'] = nl2br($r['report_desc']);
			$r['op_username'] = $r['op_username'] ? $r['op_username'] : '--';
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		return $this->itemid;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function delete($itemid) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->delete($v); }
		} else {
			$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
		}
	}

	function check($itemid, $status) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->check($v, $status); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=$status WHERE itemid=$itemid");
		}
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>