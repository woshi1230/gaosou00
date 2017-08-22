<?php
defined('IN_GAOSOU') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
$condition = "username='$_username'";
$do = new image_cat($_userid, $catid);

switch($action) {
	case 'move':
        if(!count($_POST['filelist'])>0){
            dmsg('移动失败',$forward);
        }
		if(($_GET['s_dir'])&&($_GET['d_dir'])&&($_GET['d_dir'] != $_GET['s_dir'])) {
			$cid = intval($_GET['d_dir']);

            $err = false;
            foreach($_POST['filelist'] as $file) {
                $resultimage = $db->query("UPDATE {$db->pre}upload_" . ($_userid % 10) . " SET `itemid`=" . $cid . " WHERE item='" . md5($file) . "'");
                if (!$resultimage) $err = true;
            }
            if(!$err){
                dmsg('移动成功', '?editor='.$editor.'&catid='.$_GET['s_dir']);
            }else{
                dmsg('移动失败', $forward);
            };
		} else {
            dmsg('请选择不同的目录', $forward);
//			echo "<script>alert('请选择不同的目录');location.href='$forward';</script>";
		}
		break;
	case 'catdialog':
		break;
	case 'delimage':
		if(!count($_POST['filelist'])>0){
			dmsg('图片删除失败',$forward);
		}

		$err = false;
		foreach($_POST['filelist'] as $file) {
			delete_upload($file, $_userid);
			$resultimage = $db->query("DELETE FROM {$db->pre}upload_" . ($_userid % 10) . " WHERE item='" . md5($fileurl) . "'");
			if (!$resultimage) $err = true;
		}
		if(!$err){
			dmsg('图片删除成功', $forward);
		}else{
			dmsg('图片删除失败',$forward);
		};
		break;
	case 'add':
		if($submit) {
			$category['catname'] = str_replace(' ','',$category['catname']);
			if(!$category['catname']) message('名字不能为空');
			$do->check_name($category['catname']);
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$do->table} WHERE catname='{$category[catname]}' AND parentid={$parentid} AND userid = $_userid");
			if ($r['num'] > 0) message('同一根目录下的目录名不能相同');
			$childs = '';
			$catids = array();
			$do->add($category);
			$childs .= ','.$do->catid;
			$catids[] = $do->catid;
			$list = $do->category;
			if($category['parentid']) {
				$parents = array();
				$cid = $category['parentid'];
				$parents[] = $cid;
				while(1) {
					if($list[$cid]['parentid']) {
						$parents[] = $cid = $list[$cid]['parentid'];
					} else {
						break;
					}
				}
				foreach($parents as $catid) {
					$arrchildid = $list[$catid]['child'] ? $list[$catid]['arrchildid'].$childs : $catid.$childs;
					$db->query("UPDATE {$do->table} SET child=1,arrchildid='$arrchildid' WHERE catid=$catid");
				}
			}
			dmsg('添加成功', '?editor='.$editor.'&catid='.$category['parentid']);
		}
		break;
	case 'edit':
		if($submit) {
			$category['catname'] = str_replace(' ','',$category['catname']);
			if(!$category['catname']) message('名字不能为空');
			$do->check_name($category['catname']);
			if ($category['catname'] != $catname) {
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$do->table} WHERE catname='{$category[catname]}' AND parentid={$parentid} AND userid = $_userid");
				if ($r['num'] > 0) message('同一根目录下的目录名不能相同');

				$childs = '';
				$catids = array();
				$do->edit($category);
			}
			dmsg('修改成功', '?&editor='.$editor.'&catid='.$category['parentid']);

		} else {
			$list = $do->category;
			$catname = $list[$catid]['catname'];
			$parentid = $list[$catid]['parentid'];
		}
		break;
	case 'del':
		$catid or message('请选择要删除的目录');
		$table = $DT_PRE . 'upload_' . ($_userid % 10);
//		$condition = "moduleid=2 AND itemid='$catid'";
		$condition = "upfrom='gallery' AND itemid='$catid'";
		$ra = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE {$condition}");
		$items = $ra['num'];//判断是否有图片
		if ($items) dmsg('目录不为空，删除失败',$forward);
		$result = $db->get_one("select child from {$db->pre}image_cat  WHERE catid=$catid");
		$child = $result['child'];
		if ($child == 1) dmsg('目录含有子文件夹，删除失败',$forward);
		echo "<script>
			if(confirm( '确认删除？')){
				location.href='image.php?action=checkmoveimage&editor={$editor}&catid={$catid}&child={$child}';
			}else{
				location.href='$forward';
			}
			</script>";
		break;

	case 'checkmoveimage':
		if($child == 0) {
			$do->delete($catid);
			$do->repair();
			dmsg('目录删除成功', '?editor='.$editor.'&catid='.$catid);
		}else{
			dmsg('目录含有子文件夹，删除失败', $forward);
		}
		break;

	default:
		$list = $do->category;
		// 首次进入时新增“我的图片”目录
		if (count($list) == 0) {
			$category = array();
			$category['catname'] = '我的图片';
			$category['parentid'] = 0;
			$category['arrparentid'] = '0';
			$category['child'] = 0;
			$do->add($category);
			$list = $do->get_sub();
		}
		if (!$catid) $catid = reset($list)['catid'];
		// 取得路径名称
		$idnames = array();
		if ($catid) {
			$ids = $list[$catid]['arrparentid'];
			$idarr = explode(',', $ids);
			$idarr[] = $catid;
			foreach($idarr as $r) {
				$list[$r] and $idnames[] = $list[$r];
			};
		}

		// 取得图片
		$table = $DT_PRE.'upload_'.($_userid%10);
		// 约定moduleid=2的数据为用户通过图片管理上传的图片
//		$condition = "moduleid=2 AND itemid='$catid'";
		$condition = "upfrom='gallery' AND itemid='$catid'";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE {$condition}");
		$items = $r['num'];
		$pages = pages($items, $page, $pagesize);
		$lists = array();
		$result = $db->query("SELECT * FROM {$table} WHERE {$condition} ORDER BY pid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['introduce'] = timetodate($r['addtime'], 6).'&#10;'.$r['width'].'px * '.$r['height'].'px&#10;';
			$r['ext'] = file_ext($r['fileurl']);
			$r['thumb'] = $r['fileurl'];
			$r['middle'] = str_replace('.thumb.'.$r['ext'], '.middle.'.$r['ext'], $r['thumb']);
			$r['large'] = str_replace('.thumb.'.$r['ext'], '', $r['thumb']);
			$lists[$r['pid']] = $r;
		}

		$condition = "username ='$_username' AND upfrom='gallery'";
		$r = $db->get_one("SELECT sum(filesize) as num from {$table} WHERE $condition");
		$totalM = round($r['num']/1048576,2);//共多少M
		$maxup = $MG['uploadtotalsize'];
		$percent = round(($totalM/$maxup)*100).'%';
		break;
}
include template('image', $module);

class image_cat {
	var $userid;
	var $catid;
	var $category = array();
	var $db;
	var $table;

	function image_cat($userid = 0, $catid = 0) {
		global $db, $DT_PRE;
		$this->userid = $userid;
		$this->catid = $catid;
		$this->table = $DT_PRE.'image_cat';
		$this->db = &$db;
		$this->category = $this->get_sub();
	}

	function add($category)	{
		$category['userid'] = $this->userid;
		$sqlk = $sqlv = '';
		foreach($category as $k=>$v) {
			$sqlk .= ','.$k; $sqlv .= ",'$v'";
		}
		$sqlk = substr($sqlk, 1);
		$sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->catid = $this->db->insert_id();
		if($category['parentid']) {
			$category['catid'] = $this->catid;
			$this->category[$this->catid] = $category;
			$arrparentid = $this->get_arrparentid($this->catid, $this->category);
		} else {
			$arrparentid = 0;
		}
		$catdir = $category['catdir'] ? $category['catdir'] : $this->catid;
		$this->db->query("UPDATE {$this->table} SET listorder=$this->catid,catdir='$catdir',arrparentid='$arrparentid' WHERE catid=$this->catid");
		return true;
	}

	function edit($category) {
		$catname = $category['catname'];
		$catid = $category['parentid'];
		$this->db->query("UPDATE {$this->table} SET catname ='$catname'  WHERE catid=$catid");
		return true;
	}

	function delete($catids) {
		if(is_array($catids)) {
			foreach($catids as $catid) {
				if(isset($this->category[$catid])) $this->delete($catid);
			}
		} else {
			$catid = $catids;
			if(isset($this->category[$catid])) {
				$this->db->query("DELETE FROM {$this->table} WHERE catid=$catid");
				$arrchildid = $this->category[$catid]['arrchildid'] ? $this->category[$catid]['arrchildid'] : $catid;
				$this->db->query("DELETE FROM {$this->table} WHERE catid IN ($arrchildid)");
				//if($this->userid > 4 ) $this->db->query("UPDATE ".get_table($this->userid)." SET status=0 WHERE catid IN (".$arrchildid.")");
				if($this->userid > 4 && $this->userid != 42 ) $this->db->query("UPDATE ".get_table($this->userid)." SET status=0 WHERE catid IN (".$arrchildid.")");
			}
		}
		return true;
	}

	function update($category) {
		if(!is_array($category)) return false;
		foreach($category as $k=>$v) {
			if(!$v['catname']) continue;
			$v['parentid'] = intval($v['parentid']);
			if($k == $v['parentid']) continue;
			if($v['parentid'] > 0 && !isset($this->category[$v['parentid']])) continue;
			$v['listorder'] = intval($v['listorder']);
			$v['level'] = intval($v['level']);
			$v['letter'] = preg_match("/^[a-z0-9]{1}+$/i", $v['letter']) ? strtolower($v['letter']) : '';
			if(!$v['catdir']) $v['catdir'] = $k;
			$this->db->query("UPDATE {$this->table} SET catname='$v[catname]',parentid='$v[parentid]',listorder='$v[listorder]',style='$v[style]',level='$v[level]',letter='$v[letter]',catdir='$v[catdir]' WHERE catid=$k ");
		}
		return true;
	}

	function repair() {
//		$query = $this->db->query("SELECT * FROM {$this->table} WHERE moduleid='$this->moduleid' ORDER BY listorder,catid");
		$query = $this->db->query("SELECT * FROM {$this->table} WHERE userid='$this->userid' ORDER BY listorder,catid");
		$CATEGORY = array();
		while($r = $this->db->fetch_array($query)) {
			$CATEGORY[$r['catid']] = $r;
		}
		$childs = array();
		foreach($CATEGORY as $catid => $category) {
			$CATEGORY[$catid]['arrparentid'] = $arrparentid = $this->get_arrparentid($catid, $CATEGORY);
			$CATEGORY[$catid]['catdir'] = $catdir = preg_match("/^[0-9a-z_\-\/]+$/i", $category['catdir']) ? $category['catdir'] : $catid;
			$sql = "catdir='$catdir',arrparentid='$arrparentid'";
			if(!$category['linkurl']) {
				$CATEGORY[$catid]['linkurl'] = listurl($category);//D:\xampp\htdocs\ywb2b_v02\include\global.func.php----1037h
				$sql .= ",linkurl='$category[linkurl]'";
			}
			$this->db->query("UPDATE {$this->table} SET $sql WHERE catid=$catid");
			if($arrparentid) {
				$arr = explode(',', $arrparentid);
				foreach($arr as $a) {
					if($a == 0) continue;
					isset($childs[$a]) or $childs[$a] = '';
					$childs[$a] .= ','.$catid;
				}
			}
		}
		foreach($CATEGORY as $catid => $category) {
			if(isset($childs[$catid])) {
				$CATEGORY[$catid]['arrchildid'] = $arrchildid = $catid.$childs[$catid];
				$CATEGORY[$catid]['child'] = 1;
				$this->db->query("UPDATE {$this->table} SET arrchildid='$arrchildid',child=1 WHERE catid='$catid'");
			} else {
				$CATEGORY[$catid]['arrchildid'] = $catid;
				$CATEGORY[$catid]['child'] = 0;
				$this->db->query("UPDATE {$this->table} SET arrchildid='$catid',child=0 WHERE catid='$catid'");
			}
		}
		//$this->cache($CATEGORY);
		return true;
	}


	function get_arrparentid($catid, $CATEGORY) {
		if($CATEGORY[$catid]['parentid'] && $CATEGORY[$catid]['parentid'] != $catid) {
			$parents = array();
			$cid = $catid;
			while($catid) {
				if($CATEGORY[$cid]['parentid']) {
					$parents[] = $cid = $CATEGORY[$cid]['parentid'];
				} else {
					break;
				}
			}
			$parents[] = 0;
			return implode(',', array_reverse($parents));
		} else {
			return '0';
		}
	}

	function get_arrchildid($catid, $CATEGORY) {
		$arrchildid = '';
		foreach($CATEGORY as $category) {
			if(strpos(','.$category['arrparentid'].',', ','.$catid.',') !== false) $arrchildid .= ','.$category['catid'];
		}
		return $arrchildid ? $catid.$arrchildid : $catid;
	}

	function get_sub() {
		$data = array();
		if(!$data) {
			$result = $this->db->query("SELECT * FROM {$this->table} WHERE userid='{$this->userid}' ORDER BY listorder,catid");
			while($r = $this->db->fetch_array($result)) {
				$data[$r['catid']] = $r;
			}
		}
		$a = array();
		$d = array('listorder', 'userid', 'item', 'template', 'show_template', 'seo_title', 'seo_keywords', 'seo_description', 'group_list', 'group_show', 'group_add');
		foreach($data as $r) {
			$e = $r['catid'];
			foreach($d as $_d) {
				unset($r[$_d]);
			}
			$a[$e] = $r;
		};
		return $a;
	}

	function check_name($name){
		if(strlen($name)>15) message("字符串过长");
//		$pattern = "/[\/\*<>\?\|]/";
		$pattern = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
		if(preg_match($pattern,$name)) message("非法文件名");
	}
}

?>