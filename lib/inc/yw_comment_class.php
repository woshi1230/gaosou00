<?php
class yw_comment_class {
	protected $_comment_obj;
	protected $_comment_type;
	public static function get_instance($comment_type) {
		return new yw_comment_class ( $comment_type );
	}
	function __construct($comment_type) {
		global $kekezu;
		$this->_comment_obj = keke_table_class::get_instance ( "comment" );
		$this->_comment_type = $comment_type;
	}
	function get_comment_info($comment_id){
		$comment_info = $this->_comment_obj->get_table_info('itemid', $comment_id);
		return $comment_info;
	}
	function get_comment_list($obj_id,$url, $page){
		$comment_arr = $this->_comment_obj->get_grid ( "item_id='$obj_id' and obj_type='".$this->_comment_type."' and qid=0 order by itemid desc", $url, $page,10,null,1,'comment_page');
		return $comment_arr;
	}
	function get_reply_info($obj_id){
		$reply_arr = kekezu::get_table_data("*",TB_PRE . "comment","obj_type='".$this->_comment_type."' and item_id='$obj_id' and qid>0"," addtime desc");
		return $reply_arr;
	}
	function save_comment($comment_arr,$obj_id,$is_reply=false){
		global $_lang,$kekezu,$uid,$username;
		if(!$uid){
			return -1;
			die();
		}
		$r = kekezu::check_session('task_leave',2,4);
		if($r==false){
			return -2;
			die();
		}
		strtolower ( CHARSET ) == 'gbk' and $comment_arr ['content'] = kekezu::utftogbk ( kekezu::escape($comment_arr ['content']) );
//		if(kekezu::k_match(array($kekezu->_sys_config['ban_content']),$comment_arr['content'])){
		if(kekezu::k_match(array('太黄'),$comment_arr['content'])){
			return -3;
			die();
		}
		$comment_id = $this->_comment_obj->save($comment_arr);
		$model_list = $kekezu->_model_list;
		if(!$is_reply){
			if($this->_comment_type=='task'){
				$res = db_factory::execute(sprintf(" update %switkey_task set leave_num =ifnull(leave_num,0)+1 where task_id='%d'",TB_PRE,$obj_id));
				$obj_info = db_factory::get_one(sprintf("select * from %switkey_task where task_id=%d",TB_PRE,$obj_id));
				if($obj_info['task_cash_coverage']){
					$cash = $obj_info['task_cash_coverage'];
				}else{
					$cash = $obj_info['task_cash'];
				}
			}elseif($this->_comment_type=='service'){
				$res = db_factory::execute(sprintf(" update %switkey_service set leave_num =ifnull(leave_num,0)+1 where service_id='%d'",TB_PRE,$obj_id));
				$obj_info = db_factory::get_one(sprintf("select * from %switkey_service where service_id=%d",TB_PRE,$obj_id));
			}
		}
		return $comment_id;
	}
	function del_comment($comment_id,$obj_id,$is_reply=false){
		$res =  db_factory::execute(sprintf("delete from %scomment where itemid='%d' or qid='%d'",TB_PRE,$comment_id,$comment_id));
		if(!$is_reply){
			if($this->_comment_type=='task'){
				$res and 	$res = db_factory::execute(sprintf(" update %switkey_task set leave_num =ifnull(leave_num,0)-1 where task_id='%d'",TB_PRE,$obj_id));
			}elseif($this->_comment_type=='service'){
				$res and $res = db_factory::execute(sprintf(" update %switkey_service set leave_num =ifnull(leave_num,0)-1 where service_id='%d'",TB_PRE,$obj_id));
			}
		}
		return $res;
	}
}