<?php
if($action=='delete'){
	$id = intval($id);
	$status = 0;
	$msg 	= 'Error';
	if($id){
		$objFileT = keke_table_class::get_instance('witkey_file');
		$fileInfo = $objFileT->get_table_info('file_id',$id);
		if($fileInfo['uid']==$gUid||!$fileInfo['uid']){
			if(QN_UPLOAD_OPEN){
				$kekezu->include_qiniu_file();
				$qn 	= new QiniuClass();
				$qn->delete($fileInfo['file_name']);
			}else{
				keke_file_class::del_file($fileInfo['save_name']);
				$intFileLen = strrpos($fileInfo['save_name'], '/');
				$strFileName = substr($fileInfo['save_name'], intval($intFileLen+1));
				$strFileNamePre = substr($fileInfo['save_name'],0,intval($intFileLen+1));
				file_exists($strFileNamePre.'100_'.$strFileName) and keke_file_class::del_file($strFileNamePre.'100_'.$strFileName);
				file_exists($strFileNamePre.'210_'.$strFileName) and keke_file_class::del_file($strFileNamePre.'210_'.$strFileName);
			}
			$res = $objFileT->del('file_id', $id);
			if($res){
				$status = 1;
				$msg 	= 'Success';
			}
		}
	}
	echo json_encode(array ('status'=>$status,'msg'=>$msg));
	die();
}else{
	$err = 0;
	if(QN_UPLOAD_OPEN){
		$kekezu->include_qiniu_file();
		$file 		= $_FILES[$filename]['name'];
		$filepath 	= $_FILES[$filename]['tmp_name'] ;
		$qn 	= new QiniuClass();
		$ret 	= $qn->upload($file,$filepath);
		if(!$ret){
			$err = $msg = 'upload error';
			echo json_encode(array ('err' => $err, 'msg' => $msg));
			die();
		}else{
			$url 	= $qn->download($ret['key']);
			$savefilename = $ret['key'];
			$urls = explode('?', $url);
			$path = $urls[0];
		}
	}else{
		$___y = date ( 'Y' );$___m = date ( 'm' );$___d = date ( 'd' );
		define ( 'UPLOAD_RULE', "$___y$___m/$___d/" );
		$fileFormat = explode('|',$kekezu->_sys_config['file_type']);
		$maxSize = intval($kekezu->_sys_config['max_size'])*1024*1024;
		$pathDir = setUploadPath($fileType, $objType);
		$upload = new keke_upload_class(S_ROOT.$pathDir ,$fileFormat,$maxSize);
		$savename = $upload->run( $filename , 1);
		if(!is_array ( $savename )){
			$err = $msg = $savename;
			echo json_encode(array ('err' => $err, 'msg' => $msg));
			die();
		}else{
			$name = $savename [0] ['name'];
			$path = $pathDir. $savename [0] ['saveName'];
			if($fileType == 'service'){
				$size_a = array (100, 100 );
				$size_b = array (210, 210 );
				$result = keke_img_class::resize ( $path, $size_a, $size_b, true ); 
			}
			if($fileType != 'sys'){     
				keke_glob_class::waterMark($path);
			}
			$savefilename = $savename [0] ['name'];
		}
	}
	if(strtoupper(CHARSET) =='GBK'){
		$savefilename = kekezu::utftogbk($savefilename);
	}
	$data = array();
	$data ['file_name'] = $savefilename;
	$data ['save_name'] = $path;
	$data ['uid'] 		= $gUid;
	$data ['username'] 	= $gUsername;
	$data ['obj_type'] 	= $objType;
	$data ['task_id'] 	= $taskId;
	$data ['work_id'] 	= $workId;
	$data ['on_time'] 	= time();
	$fileId = saveToFiles($data);
	$msg = array ('url' => $path,'filename' => $filename, 'name' => $name,'fileid'=>intval($fileId));
	echo json_encode(array ('err' => $err, 'msg' => $msg));
	die();
}
function setUploadPath($fileType,$objType){
	$pathDir = 'file/upload/';
	if($fileType =='sys'&&$objType =='auth'){		
		$pathDir .= $fileType.'/'.$objType.'/';
	}elseif($fileType =='sys'&&$objType =='ad'){	
		$pathDir .= $fileType.'/'.$objType.'/';
	}elseif($fileType =='sys'&&$objType =='mark'){	
		$pathDir .= $fileType.'/'.$objType.'/';
	}elseif($fileType =='sys'&&$objType =='tools'){	
		$pathDir .= $fileType.'/'.$objType.'/';
	}elseif($fileType =='space'){					
		$pathDir .= $fileType.'/';
	}else{
		$pathDir .= UPLOAD_RULE;
	}
	return $pathDir;
}
function saveToFiles($data){
	$objFileT = keke_table_class::get_instance('witkey_file');
	return $objFileT->save ( $data);
}