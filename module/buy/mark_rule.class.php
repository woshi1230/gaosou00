<?php
defined('IN_GAOSOU') or exit('Access Denied');
class mark_rule {
    var $moduleid;
    var $itemid;
    var $db;
    var $table;
    var $split;
    var $fields;
    var $errmsg = errmsg;

    function mark_rule($moduleid) {
        global $db, $MOD;
        $this->moduleid = $moduleid;
        $this->table = 'yw_witkey_mark_rule';
        $this->split = $MOD['split'];
        $this->db = &$db;
        $this->fields = array('mark_rule_id','g_value','m_value','g_title','m_title','g_ico','m_ico');
    }

    function get_list($condition = '1=1', $order = 'mark_rule_id', $cache = '') {
        global $MOD, $pages, $page, $pagesize, $offset, $items, $sum;
        if($page > 1 && $sum) {
            $items = $sum;
        } else {
            $r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition", $cache);
            $items = $r['num'];
        }
//        $pages = defined('CATID') ? listpages(1, CATID, $items, $page, $pagesize, 10, $MOD['linkurl']) : pages($items, $page, $pagesize);
        if($items < 1) return array();
        $lists = $catids = $CATS = array();
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize", $cache);
        while($r = $this->db->fetch_array($result)) {
            $lists[] = $r;
        }
        return $lists;
    }

    function get_one() {
        $r = $this->db->get_one("SELECT * FROM {$this->table} WHERE mark_rule_id=$this->itemid");
        if($r) {
            return $r;
        } else {
            return array();
        }
    }

    function edit($post) {
        $sql = '';
        foreach($post as $k=>$v) {
            if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
        }
        $sql = substr($sql, 1);
        $this->db->query("UPDATE {$this->table} SET $sql WHERE mark_rule_id=$this->itemid");
        clear_upload($post['g_ico'].$post['m_ico'], $this->itemid);
        return true;
    }

}