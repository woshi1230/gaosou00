<?phpclass Keke_witkey_model_class{	public $_db;	public $_tablename;	public $_dbop;	public $_model_id;	public $_model_code;	public $_model_name;	public $_model_dir;	public $_model_type;	public $_model_dev;	public $_model_status;	public $_model_desc;	public $_on_time;	public $_hide_mode;	public $_listorder;	public $_model_intro;	public $_indus_bid;	public $_config;	public $_open_custom;	public $_cache_config = array ('is_cache' => 0, 'time' => 0 );	public $_replace=0;	public $_where;	function  keke_witkey_model_class(){		$this->_db = new db_factory ( );		$this->_dbop = $this->_db->create(DBTYPE);		$this->_tablename = TB_PRE."witkey_model";	}	public function getModel_id(){		return $this->_model_id ;	}	public function getModel_code(){		return $this->_model_code ;	}	public function getModel_name(){		return $this->_model_name ;	}	public function getModel_dir(){		return $this->_model_dir ;	}	public function getModel_type(){		return $this->_model_type ;	}	public function getModel_dev(){		return $this->_model_dev ;	}	public function getModel_status(){		return $this->_model_status ;	}	public function getModel_desc(){		return $this->_model_desc ;	}	public function getOn_time(){		return $this->_on_time ;	}	public function getHide_mode(){		return $this->_hide_mode ;	}	public function getListorder(){		return $this->_listorder ;	}	public function getModel_intro(){		return $this->_model_intro ;	}	public function getIndus_bid(){		return $this->_indus_bid ;	}	public function getConfig(){		return $this->_config ;	}	public function getOpen_custom(){		return $this->_open_custom ;	}	public function getWhere(){		return $this->_where ;	}	public function getCache_config() {		return $this->_cache_config;	}	public function setModel_id($value){		$this->_model_id = $value;	}	public function setModel_code($value){		$this->_model_code = $value;	}	public function setModel_name($value){		$this->_model_name = $value;	}	public function setModel_dir($value){		$this->_model_dir = $value;	}	public function setModel_type($value){		$this->_model_type = $value;	}	public function setModel_dev($value){		$this->_model_dev = $value;	}	public function setModel_status($value){		$this->_model_status = $value;	}	public function setModel_desc($value){		$this->_model_desc = $value;	}	public function setOn_time($value){		$this->_on_time = $value;	}	public function setHide_mode($value){		$this->_hide_mode = $value;	}	public function setListorder($value){		$this->_listorder = $value;	}	public function setModel_intro($value){		$this->_model_intro = $value;	}	public function setIndus_bid($value){		$this->_indus_bid = $value;	}	public function setConfig($value){		$this->_config = $value;	}	public function setOpen_custom($value){		$this->_open_custom = $value;	}	public function setWhere($value){		$this->_where = $value;	}	public function setCache_config($_cache_config) {		$this->_cache_config = $_cache_config;	}	public  function __set($property_name, $value) {		$this->$property_name = $value;	}	public function __get($property_name) {		if (isset ( $this->$property_name )) {			return $this->$property_name;		} else {			return null;		}	}	function create_keke_witkey_model(){		$data =  array();		if(!is_null($this->_model_id)){			$data['model_id']=$this->_model_id;		}		if(!is_null($this->_model_code)){			$data['model_code']=$this->_model_code;		}		if(!is_null($this->_model_name)){			$data['model_name']=$this->_model_name;		}		if(!is_null($this->_model_dir)){			$data['model_dir']=$this->_model_dir;		}		if(!is_null($this->_model_type)){			$data['model_type']=$this->_model_type;		}		if(!is_null($this->_model_dev)){			$data['model_dev']=$this->_model_dev;		}		if(!is_null($this->_model_status)){			$data['model_status']=$this->_model_status;		}		if(!is_null($this->_model_desc)){			$data['model_desc']=$this->_model_desc;		}		if(!is_null($this->_on_time)){			$data['on_time']=$this->_on_time;		}		if(!is_null($this->_hide_mode)){			$data['hide_mode']=$this->_hide_mode;		}		if(!is_null($this->_listorder)){			$data['listorder']=$this->_listorder;		}		if(!is_null($this->_model_intro)){			$data['model_intro']=$this->_model_intro;		}		if(!is_null($this->_indus_bid)){			$data['indus_bid']=$this->_indus_bid;		}		if(!is_null($this->_config)){			$data['config']=$this->_config;		}		if(!is_null($this->_open_custom)){			$data['open_custom']=$this->_open_custom;		}		return $this->_model_id = $this->_db->inserttable($this->_tablename,$data,1,$this->_replace);	}	function edit_keke_witkey_model(){		$data =  array();		if(!is_null($this->_model_id)){			$data['model_id']=$this->_model_id;		}		if(!is_null($this->_model_code)){			$data['model_code']=$this->_model_code;		}		if(!is_null($this->_model_name)){			$data['model_name']=$this->_model_name;		}		if(!is_null($this->_model_dir)){			$data['model_dir']=$this->_model_dir;		}		if(!is_null($this->_model_type)){			$data['model_type']=$this->_model_type;		}		if(!is_null($this->_model_dev)){			$data['model_dev']=$this->_model_dev;		}		if(!is_null($this->_model_status)){			$data['model_status']=$this->_model_status;		}		if(!is_null($this->_model_desc)){			$data['model_desc']=$this->_model_desc;		}		if(!is_null($this->_on_time)){			$data['on_time']=$this->_on_time;		}		if(!is_null($this->_hide_mode)){			$data['hide_mode']=$this->_hide_mode;		}		if(!is_null($this->_listorder)){			$data['listorder']=$this->_listorder;		}		if(!is_null($this->_model_intro)){			$data['model_intro']=$this->_model_intro;		}		if(!is_null($this->_indus_bid)){			$data['indus_bid']=$this->_indus_bid;		}		if(!is_null($this->_config)){			$data['config']=$this->_config;		}		if(!is_null($this->_open_custom)){			$data['open_custom']=$this->_open_custom;		}		if($this->_where){			return $this->_db->updatetable($this->_tablename,$data,$this->getWhere());		}		else{			$where = array('model_id' => $this->_model_id);			return $this->_db->updatetable($this->_tablename,$data,$where);		}	}	function query_keke_witkey_model($is_cache=0, $cache_time=0){		if($this->_where){			$sql = "select * from $this->_tablename where ".$this->_where;		}		else{			$sql = "select * from $this->_tablename";		}		if ($is_cache) {			$this->_cache_config ['is_cache'] = $is_cache;		}		if ($cache_time) {			$this->_cache_config ['time'] = $cache_time;		}		if ($this->_cache_config ['is_cache']) {			if (CACHE_TYPE) {				$keke_cache = new keke_cache_class ( CACHE_TYPE );				$id = $this->_tablename . ($this->_where?"_" .substr(md5 ( $this->_where ),0,6):'');				$data = $keke_cache->get ( $id );				if ($data) {					return $data;				} else {					$res = $this->_dbop->query ( $sql );					$keke_cache->set ( $id, $res,$this->_cache_config['time'] );					$this->_where = "";					return $res;				}			}		}else{			$this->_where = "";			return  $this->_dbop->query ( $sql );		}	}	function count_keke_witkey_model(){		if($this->_where){			$sql = "select count(*) as count from $this->_tablename where ".$this->_where;		}		else{			$sql = "select count(*) as count from $this->_tablename";		}		$this->_where = "";		return $this->_dbop->getCount($sql);	}	function del_keke_witkey_model(){		if($this->_where){			$sql = "delete from $this->_tablename where ".$this->_where;		}		else{			$sql = "delete from $this->_tablename where model_id = $this->_model_id ";		}		$this->_where = "";		return $this->_dbop->execute($sql);	}	public static function query ( $sql ) {		$dbdata = array (
  1 => 
  array (
    'model_id' => '1',
    'model_code' => 'sreward',
    'model_name' => '单人悬赏',
    'config' => 'a:17:{s:10:"audit_cash";s:3:"100";s:8:"max_cash";s:1:"0";s:8:"min_cash";s:4:"0.01";s:9:"task_rate";s:2:"10";s:14:"task_fail_rate";s:2:"10";s:11:"work_hidden";s:1:"0";s:13:"notice_period";s:1:"0";s:7:"min_day";s:1:"1";s:11:"vote_period";s:1:"1";s:14:"reg_vote_limit";s:1:"1";s:11:"choose_time";s:1:"1";s:19:"agree_complete_time";s:1:"2";s:14:"min_delay_cash";s:2:"10";s:9:"max_delay";s:1:"2";s:10:"end_action";s:5:"split";s:10:"witkey_num";s:1:"2";s:16:"auto_choose_rule";s:9:"work_time";}',
    'model_desc' => '计件悬赏任务的一般流程是：<br />
1、雇主发布任务将任务金额托管到网站平台<br />
2、众多高手参与并提交方案<br />
3、雇主选择满意方案，设置方案入围状态，商议最终价格<br />
4、雇主从入围方案中选择中标方案<br />
5、方案中标发放赏金。如果议价金额小于托管金额网站返还雇主多余赏金。',
  ),
  2 => 
  array (
    'model_id' => '2',
    'model_code' => 'mreward',
    'model_name' => '多人悬赏',
    'config' => 'a:13:{s:10:"audit_cash";s:3:"100";s:8:"max_cash";s:4:"1000";s:8:"min_cash";s:4:"0.01";s:9:"task_rate";s:2:"20";s:14:"task_fail_rate";s:1:"5";s:11:"work_hidden";s:1:"0";s:13:"notice_period";s:1:"0";s:7:"min_day";s:1:"1";s:11:"choose_time";s:1:"1";s:14:"min_delay_cash";s:1:"2";s:9:"max_delay";s:1:"3";s:10:"end_action";s:6:"refund";s:16:"auto_choose_rule";s:8:"take_num";}',
    'model_desc' => '多人悬赏任务是指您在发布任务时，先将任务赏金全额托管到平台，再从交稿中选出满意的稿件任务。该任务获奖任务为雇主发布任务时设置的奖项总数目（一等奖，二等奖，三等奖的总和）,获奖者将会根据自己的奖项排名获取相应的赏金。<br />
<br />
多人悬赏任务的一般流程是：<br />
1、雇主发布任务会将对应的任务金额托管到网站平台；<br />
2、众多高手参与任务并提交方案，等待雇主选择方案；<br />
3、雇主会根据方案的优劣，设置相应的稿件奖项排名（如：一等奖，二等奖等）；<br />
4、雇主分配奖项后，如果选稿期结束该任务会进入公示期，在该时期威客可以用相应操作权限，一旦公示期结束，平台会给获奖的高手支付赏金（平台提成一定的比例），如果该任务还有多余的金额，平台会将多余的金额返还给雇主（平台提成一定的比例）。<br />
',
  ),
  3 => 
  array (
    'model_id' => '3',
    'model_code' => 'preward',
    'model_name' => '计件悬赏',
    'config' => 'a:13:{s:10:"audit_cash";s:3:"100";s:8:"max_cash";s:1:"0";s:8:"min_cash";s:4:"0.02";s:9:"task_rate";s:2:"10";s:14:"task_fail_rate";s:1:"5";s:11:"work_hidden";s:1:"0";s:7:"min_day";s:1:"2";s:11:"choose_time";s:1:"1";s:8:"mark_day";s:1:"1";s:14:"min_delay_cash";s:1:"1";s:9:"max_delay";s:1:"2";s:12:"work_percent";s:3:"200";s:15:"is_auto_adjourn";s:1:"1";}',
    'model_desc' => '计件悬赏任务的一般流程是：<br />
1、雇主发布任务将任务金额托管到网站平台<br />
2、众多高手参与并提交方案<br />
3、雇主选择满意方案，设置方案中标状态<br />
4、方案中标发放赏金',
  ),
  4 => 
  array (
    'model_id' => '4',
    'model_code' => 'tender',
    'model_name' => '普通招标',
    'config' => 'a:6:{s:8:"zb_audit";s:1:"1";s:11:"work_hidden";s:1:"0";s:7:"zb_fees";s:1:"1";s:11:"zb_max_time";s:3:"400";s:11:"zb_min_time";s:1:"2";s:11:"choose_time";s:1:"2";}',
    'model_desc' => '普通招标，雇主选择中标者后，交付将在线下完成，雇主确认后，任务完成，普能招标，网站只收取固定的服务费用,普通招标将不能增涨双方的信誉值，与能力值',
  ),
  5 => 
  array (
    'model_id' => '5',
    'model_code' => 'dtender',
    'model_name' => '订金招标',
    'config' => 'a:11:{s:10:"open_audit";s:4:"open";s:11:"work_hidden";s:1:"0";s:11:"pay_methods";s:5:"fixed";s:7:"deposit";s:2:"30";s:13:"deposit_scale";s:2:"30";s:9:"task_rate";s:2:"10";s:14:"task_fail_rate";s:2:"10";s:12:"bid_max_time";s:3:"100";s:12:"bid_min_time";s:1:"1";s:14:"pay_limit_time";s:1:"2";s:18:"confirm_limit_time";s:3:"100";}',
    'model_desc' => '订金招标是指托管任务订金，选择应标高手完成任务的任务类型。任务采用选择高手完成任务的方式，避免了全款悬赏任务高手作品浪费的现象。<br />
<br />
订金招标流程较复杂，用时较长，但效果较好且能有效防止诈骗，特别适合大中型任务的发布这些任务可以考虑使用订金招标：VI/SI等大型设计项目，长期的画册设计外包，多页面的网页设计，电子杂志设计，网站程序开发，软件开发，音视频拍摄/调整，视频短片，大型翻译…… <br />
<br />
任务流程：雇主发布订金招标任务并托管任务款后，等待高手来参加任务。高手可以通过搜索等方式查看到该订金招标任务，并依据任务雇主的需求，提出解决方案。雇主查看到最合适最优秀的方案后，即可邀请提交此方案的高手写任务合同。双方对任务合同协调无异议后，即可确定该合同生效，并进入任务实施阶段。分期发放任务赏金。订金招标任务成功结束。<br />
',
  ),
  6 => 
  array (
    'model_id' => '6',
    'model_code' => 'match',
    'model_name' => '速配任务',
    'config' => 'a:8:{s:9:"task_rate";s:2:"10";s:7:"deposit";s:2:"99";s:12:"deposit_rate";s:2:"10";s:8:"defeated";s:1:"1";s:14:"task_fail_rate";s:1:"5";s:7:"min_day";s:1:"1";s:7:"max_day";s:2:"50";s:7:"cutdown";s:1:"0";}',
    'model_desc' => '速配任务',
  ),
);		return $dbdata;	}	public static function get_one ( $sql, $id ) {		$datalist = array ();		$dbdata = Keke_witkey_model_class::query($sql);		foreach($dbdata as $rs){			if ($rs ["model_id"] == $id) {				$datalist [] = $rs;				return $datalist;			}		}		return $datalist;	}}?>