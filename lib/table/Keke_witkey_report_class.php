<?phpclass Keke_witkey_report_class{	public $_db;	public $_tablename;	public $_dbop;	public $_report_id;	public $_obj;	public $_obj_id;	public $_origin_id;	public $_front_status;	public $_uid;	public $_username;	public $_user_type;	public $_to_uid;	public $_to_username;	public $_is_hide;	public $_report_desc;	public $_report_file;	public $_report_status;	public $_on_time;	public $_report_type;	public $_op_uid;	public $_op_username;	public $_op_result;	public $_op_time;	public $_phone;	public $_qq;	public $_report_reason;	public $_cache_config = array ('is_cache' => 0, 'time' => 0 );	public $_replace=0;	public $_where;	function  keke_witkey_report_class(){		$this->_db = new db_factory ( );		$this->_dbop = $this->_db->create(DBTYPE);		$this->_tablename = TB_PRE."witkey_report";	}	public function getReport_id(){		return $this->_report_id ;	}	public function getObj(){		return $this->_obj ;	}	public function getObj_id(){		return $this->_obj_id ;	}	public function getOrigin_id(){		return $this->_origin_id ;	}	public function getFront_status(){		return $this->_front_status ;	}	public function getUid(){		return $this->_uid ;	}	public function getUsername(){		return $this->_username ;	}	public function getUser_type(){		return $this->_user_type ;	}	public function getTo_uid(){		return $this->_to_uid ;	}	public function getTo_username(){		return $this->_to_username ;	}	public function getIs_hide(){		return $this->_is_hide ;	}	public function getReport_desc(){		return $this->_report_desc ;	}	public function getReport_file(){		return $this->_report_file ;	}	public function getReport_status(){		return $this->_report_status ;	}	public function getOn_time(){		return $this->_on_time ;	}	public function getReport_type(){		return $this->_report_type ;	}	public function getOp_uid(){		return $this->_op_uid ;	}	public function getOp_username(){		return $this->_op_username ;	}	public function getOp_result(){		return $this->_op_result ;	}	public function getOp_time(){		return $this->_op_time ;	}	public function getPhone(){		return $this->_phone ;	}	public function getQq(){		return $this->_qq ;	}	public function getReport_reason(){		return $this->_report_reason ;	}	public function getWhere(){		return $this->_where ;	}	public function getCache_config() {		return $this->_cache_config;	}	public function setReport_id($value){		$this->_report_id = $value;	}	public function setObj($value){		$this->_obj = $value;	}	public function setObj_id($value){		$this->_obj_id = $value;	}	public function setOrigin_id($value){		$this->_origin_id = $value;	}	public function setFront_status($value){		$this->_front_status = $value;	}	public function setUid($value){		$this->_uid = $value;	}	public function setUsername($value){		$this->_username = $value;	}	public function setUser_type($value){		$this->_user_type = $value;	}	public function setTo_uid($value){		$this->_to_uid = $value;	}	public function setTo_username($value){		$this->_to_username = $value;	}	public function setIs_hide($value){		$this->_is_hide = $value;	}	public function setReport_desc($value){		$this->_report_desc = $value;	}	public function setReport_file($value){		$this->_report_file = $value;	}	public function setReport_status($value){		$this->_report_status = $value;	}	public function setOn_time($value){		$this->_on_time = $value;	}	public function setReport_type($value){		$this->_report_type = $value;	}	public function setOp_uid($value){		$this->_op_uid = $value;	}	public function setOp_username($value){		$this->_op_username = $value;	}	public function setOp_result($value){		$this->_op_result = $value;	}	public function setOp_time($value){		$this->_op_time = $value;	}	public function setPhone($value){		$this->_phone = $value;	}	public function setQq($value){		$this->_qq = $value;	}	public function setReport_reason($value){		$this->_report_reason = $value;	}	public function setWhere($value){		$this->_where = $value;	}	public function setCache_config($_cache_config) {		$this->_cache_config = $_cache_config;	}	public  function __set($property_name, $value) {		$this->$property_name = $value;	}	public function __get($property_name) {		if (isset ( $this->$property_name )) {			return $this->$property_name;		} else {			return null;		}	}	function create_keke_witkey_report(){		$data =  array();		if(!is_null($this->_report_id)){			$data['report_id']=$this->_report_id;		}		if(!is_null($this->_obj)){			$data['obj']=$this->_obj;		}		if(!is_null($this->_obj_id)){			$data['obj_id']=$this->_obj_id;		}		if(!is_null($this->_origin_id)){			$data['origin_id']=$this->_origin_id;		}		if(!is_null($this->_front_status)){			$data['front_status']=$this->_front_status;		}		if(!is_null($this->_uid)){			$data['uid']=$this->_uid;		}		if(!is_null($this->_username)){			$data['username']=$this->_username;		}		if(!is_null($this->_user_type)){			$data['user_type']=$this->_user_type;		}		if(!is_null($this->_to_uid)){			$data['to_uid']=$this->_to_uid;		}		if(!is_null($this->_to_username)){			$data['to_username']=$this->_to_username;		}		if(!is_null($this->_is_hide)){			$data['is_hide']=$this->_is_hide;		}		if(!is_null($this->_report_desc)){			$data['report_desc']=$this->_report_desc;		}		if(!is_null($this->_report_file)){			$data['report_file']=$this->_report_file;		}		if(!is_null($this->_report_status)){			$data['report_status']=$this->_report_status;		}		if(!is_null($this->_on_time)){			$data['on_time']=$this->_on_time;		}		if(!is_null($this->_report_type)){			$data['report_type']=$this->_report_type;		}		if(!is_null($this->_op_uid)){			$data['op_uid']=$this->_op_uid;		}		if(!is_null($this->_op_username)){			$data['op_username']=$this->_op_username;		}		if(!is_null($this->_op_result)){			$data['op_result']=$this->_op_result;		}		if(!is_null($this->_op_time)){			$data['op_time']=$this->_op_time;		}		if(!is_null($this->_phone)){			$data['phone']=$this->_phone;		}		if(!is_null($this->_qq)){			$data['qq']=$this->_qq;		}		if(!is_null($this->_report_reason)){			$data['report_reason']=$this->_report_reason;		}		return $this->_report_id = $this->_db->inserttable($this->_tablename,$data,1,$this->_replace);	}	function edit_keke_witkey_report(){		$data =  array();		if(!is_null($this->_report_id)){			$data['report_id']=$this->_report_id;		}		if(!is_null($this->_obj)){			$data['obj']=$this->_obj;		}		if(!is_null($this->_obj_id)){			$data['obj_id']=$this->_obj_id;		}		if(!is_null($this->_origin_id)){			$data['origin_id']=$this->_origin_id;		}		if(!is_null($this->_front_status)){			$data['front_status']=$this->_front_status;		}		if(!is_null($this->_uid)){			$data['uid']=$this->_uid;		}		if(!is_null($this->_username)){			$data['username']=$this->_username;		}		if(!is_null($this->_user_type)){			$data['user_type']=$this->_user_type;		}		if(!is_null($this->_to_uid)){			$data['to_uid']=$this->_to_uid;		}		if(!is_null($this->_to_username)){			$data['to_username']=$this->_to_username;		}		if(!is_null($this->_is_hide)){			$data['is_hide']=$this->_is_hide;		}		if(!is_null($this->_report_desc)){			$data['report_desc']=$this->_report_desc;		}		if(!is_null($this->_report_file)){			$data['report_file']=$this->_report_file;		}		if(!is_null($this->_report_status)){			$data['report_status']=$this->_report_status;		}		if(!is_null($this->_on_time)){			$data['on_time']=$this->_on_time;		}		if(!is_null($this->_report_type)){			$data['report_type']=$this->_report_type;		}		if(!is_null($this->_op_uid)){			$data['op_uid']=$this->_op_uid;		}		if(!is_null($this->_op_username)){			$data['op_username']=$this->_op_username;		}		if(!is_null($this->_op_result)){			$data['op_result']=$this->_op_result;		}		if(!is_null($this->_op_time)){			$data['op_time']=$this->_op_time;		}		if(!is_null($this->_phone)){			$data['phone']=$this->_phone;		}		if(!is_null($this->_qq)){			$data['qq']=$this->_qq;		}		if(!is_null($this->_report_reason)){			$data['report_reason']=$this->_report_reason;		}		if($this->_where){			return $this->_db->updatetable($this->_tablename,$data,$this->getWhere());		}		else{			$where = array('report_id' => $this->_report_id);			return $this->_db->updatetable($this->_tablename,$data,$where);		}	}	function query_keke_witkey_report($is_cache=0, $cache_time=0){		if($this->_where){			$sql = "select * from $this->_tablename where ".$this->_where;		}		else{			$sql = "select * from $this->_tablename";		}		if ($is_cache) {			$this->_cache_config ['is_cache'] = $is_cache;		}		if ($cache_time) {			$this->_cache_config ['time'] = $cache_time;		}		if ($this->_cache_config ['is_cache']) {			if (CACHE_TYPE) {				$keke_cache = new keke_cache_class ( CACHE_TYPE );				$id = $this->_tablename . ($this->_where?"_" .substr(md5 ( $this->_where ),0,6):'');				$data = $keke_cache->get ( $id );				if ($data) {					return $data;				} else {					$res = $this->_dbop->query ( $sql );					$keke_cache->set ( $id, $res,$this->_cache_config['time'] );					$this->_where = "";					return $res;				}			}		}else{			$this->_where = "";			return  $this->_dbop->query ( $sql );		}	}	function count_keke_witkey_report(){		if($this->_where){			$sql = "select count(*) as count from $this->_tablename where ".$this->_where;		}		else{			$sql = "select count(*) as count from $this->_tablename";		}		$this->_where = "";		return $this->_dbop->getCount($sql);	}	function del_keke_witkey_report(){		if($this->_where){			$sql = "delete from $this->_tablename where ".$this->_where;		}		else{			$sql = "delete from $this->_tablename where report_id = $this->_report_id ";		}		$this->_where = "";		return $this->_dbop->execute($sql);	}}?>