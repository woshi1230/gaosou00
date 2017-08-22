<?php
$sesname = 'test';
if (isset ( $formhash ) && kekezu::submitcheck ( $formhash )) {
	$_SESSION[$sesname]['fileid1'] = $_POST['fileid1'];
	$_SESSION[$sesname]['fileid2'] = $_POST['fileid2'];
	kekezu::show_msg('上传成功','index.php?do=uploadexamples','3','','success');
}else{
	$fileid1 = explode(',', $_SESSION[$sesname]['fileid1']);
	$arrFileLists1 = array();
	$fd1 = array();
	foreach ($fileid1 as $k => $v){
		$info  = CommonClass::getFileInfoByFileId($v);
		if($info){
			$arrFileLists1[$k] = $info;
			$fd1[] = $v;
		}
	}
	$fd1 and $fileid1 = implode(',', $fd1) or $fileid1 = '';
	$fileid2 = explode('|', $_SESSION[$sesname]['fileid2']);
	$arrFileLists2 = array();
	$fd2 = array();
	foreach ($fileid2 as $k => $v){
		$info2 = CommonClass::getFileInfoBySavename($v);
		if($info2){
			$arrFileLists2[$k] = $info2;
			$fd2[] = $v;
		}
	}
	$fd2 and $fileid2 = implode('|', $fd2) or $fileid2 = ''; 
}