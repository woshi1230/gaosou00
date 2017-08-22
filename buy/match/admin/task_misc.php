<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
$page = max ( $page, 1 );
$limit = max ( $limit, 5 );
$url = 'index.php?do=' . $do . '&model_id=' . $model_id . '&view=edit&task_id=' . $task_id . '&op=' . $op;
switch ($op) {
	case 'work' : 
		if ($ac && $work_id) {
			switch ($ac) {
				case 'del' : 
					db_factory::execute ("update ".TB_PRE."witkey_task set work_num=work_num-1 where task_id =(select task_id from ".TB_PRE."witkey_task_work where work_id=".intval($work_id).")");
					$res = db_factory::execute ( sprintf ( 'delete  from %switkey_task_work where work_id=%d', TB_PRE, intval ( $work_id ) ) );
					$res_match = db_factory::execute(sprintf('delete from %switkey_match_work where work_id=%d',TB_PRE,intval($work_id)));
					if ($res&&$res_match) {
						db_factory::execute ( sprintf ( ' delete from %switkey_comment where obj_id=%d', TB_PRE, intval ( $work_id ) ) );
					}
					$res and kekezu::echojson ( '', 1 ) or kekezu::echojson ( '', 0 );
					die ();
					break;
				case 'file' : 
					$f_list = db_factory::query ( sprintf ( ' select a.file_id,a.file_name,a.save_name from %switkey_file a 
							left join %switkey_task_work b on a.file_id in (b.work_file) where b.work_id=%d and b.work_file is not null ', TB_PRE, TB_PRE, $work_id ) );
					break;
				case 'comm' : 
					$c_list = db_factory::query ( sprintf ( ' select a.content,a.on_time from %switkey_comment a 
						left join %switkey_task_work b on a.obj_id=b.work_id where b.work_id=%d', TB_PRE, TB_PRE, $work_id ) );
					break;
			}
			require keke_tpl_class::template ( 'task/' . $model_info ['model_dir'] . '/admin/tpl/task_edit_ext' );
			die ();
		} else {
			$page or $page = 1;
			$page_size or $page_size=10;
			$page_obj = $kekezu->_page_obj;
			$page_obj->setAjax(1);
			$page_obj->setAjaxDom('ajax_dom');
			$sql = sprintf("select w_basic.*, w_match.`wiki_deposit`,w_match.`deposit_cash`,w_match.`witkey_contact`,w_match.`deposit_credit` from %switkey_task_work w_basic left join %switkey_task_match_work w_match on w_basic.`task_id`=w_match.`work_id` where w_basic.task_id=%d",TB_PRE,TB_PRE,$task_id);
			$tmp = db_factory::query($sql);
			$pages = $page_obj->page_by_arr($tmp, $page_size, $page, $url);
			$list = $pages ['data'];
			$satus_arr = match_task_class::get_work_status ();
			$platform_arr = keke_glob_class::get_oauth_type();
		}
		break;
	case 'comm' : 
		if ($ac && $comm_id) {
			$id = intval ( $comm_id );
			switch ($ac) {
				case 'del' : 
					$sql = ' delete from %switkey_comment where comment_id=%d';
					$type == 1 and $sql .= ' or p_id=%d'; 
					$res = db_factory::execute ( sprintf ( $sql, TB_PRE, $id, $id ) );
					$res and kekezu::echojson ( '', 1 ) or kekezu::echojson ( '', 0 );
					die ();
					break;
				case 'load' : 
					$list = db_factory::query ( sprintf ( ' select * from %switkey_comment where p_id=%d', TB_PRE, $id ) );
					require keke_tpl_class::template ( 'task/' . $model_info ['model_dir'] . '/admin/tpl/task_edit_ext' );
					die ();
					break;
			}
		} else {
			$o = keke_table_class::get_instance ( 'witkey_comment' );
			$tmp = $o->get_grid ( 'obj_id=' . $task_id . ' and p_id=0', $url, $page, $limit, ' order by on_time desc ', 1, 'ajax_dom' );
			$list = $tmp ['data'];
			$pages = $tmp ['pages'];
		}
		break;
	case 'mark' : 
		$o = keke_table_class::get_instance ( 'witkey_mark' );
		$tmp = $o->get_grid ( "origin_id=$service_id and `mark_status`!=0 and model_code='{$model_info ['model_code']}'", $url, $page, $limit, ' order by mark_time desc ', 1, 'ajax_dom' );
		$list = $tmp ['data'];
		$pages = $tmp ['pages'];
		break;
}