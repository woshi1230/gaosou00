<?php
$ky = htmlspecialchars ( $ky );
$ky = kekezu::escape ( $ky );
$search=intval($search);
$arrHwStatus = db_factory::query("select v from ".TB_PRE."witkey_basic_config where k='hot_words_status'");
$arrUpdateStatus = db_factory::query("select v from ".TB_PRE."witkey_basic_config where k='update_status'");
if($arrHwStatus[0]['v'] == 'open'){
	if($arrUpdateStatus[0]['v'] == 'auto'){
	    if($ky){
	        $searchlist=db_factory::query("select words from ".TB_PRE."witkey_hotwords where words like '%$ky%' and auto=1 order by count desc limit 5");
	    }else{
	        $searchlist=db_factory::query("select words from ".TB_PRE."witkey_hotwords where auto=1 order by count desc limit 5");
	    }
	    if($searchlist){
	        $hotsearch="<ul class='dropdown-menu' role='menu'  id='hotsearch'  aria-labelledby='dLabel'>";
	        foreach($searchlist as $v){
	            if($search==1){
	                $hotsearch.="<li><a href='index.php?do=tasklist&ky={$v[words]}'>$v[words]</a></li>";
	            }elseif($search==2){
	                $hotsearch.="<li><a href='index.php?do=goodslist&ky={$v[words]}'>$v[words]</a></li>";
	            }else{
	                $hotsearch.="<li><a href='index.php?do=sellerlist&ky={$v[words]}'>$v[words]</a></li>";
	            }
	        }
	        $hotsearch.="</ul>";
	        echo $hotsearch;die();
	    }else{
	        echo '';die;
	    }
	}else{
	    if($ky){
	       $searchlist=db_factory::query("select words from ".TB_PRE."witkey_hotwords where words like '%$ky%' and auto!=1 order by sort asc limit 5");
	    }else{
	        $searchlist=db_factory::query("select words from ".TB_PRE."witkey_hotwords where auto!=1 order by count desc limit 5");
	    }
	    if($searchlist){
	        $hotsearch="<ul class='dropdown-menu' role='menu'  id='hotsearch'  aria-labelledby='dLabel'>";
		    foreach($searchlist as $v){
				if($search==1){
					$hotsearch.="<li><a href='index.php?do=tasklist&ky={$v[words]}'>$v[words]</a></li>";
				}elseif($search==2){
					$hotsearch.="<li><a href='index.php?do=goodslist&ky={$v[words]}'>$v[words]</a></li>";
				}else{
					$hotsearch.="<li><a href='index.php?do=sellerlist&ky={$v[words]}'>$v[words]</a></li>";
				}
			}
	       $hotsearch.="</ul>";
	       echo $hotsearch;die();
	    }else{
	        echo '';die;
	    }
	}
}else{
	return false;die();
}