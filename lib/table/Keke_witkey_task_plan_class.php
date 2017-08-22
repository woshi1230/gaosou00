<?phpclass Keke_witkey_task_plan_class{	public $_db;	public $_tablename;	public $_dbop;	public $_plan_id;	public $_bid_id;	public $_task_id;	public $_plan_title;	public $_plan_desc;	public $_plan_step;	public $_plan_amount;	public $_plan_status;	public $_start_time;	public $_end_time;	public $_over_time;	public $_cache_config = array ('is_cache' => 0, 'time' => 0 );	public $_replace=0;	public $_where;	function  keke_witkey_task_plan_class(){		$this->_db = new db_factory ( );		$this->_dbop = $this->_db->create(DBTYPE);		$this->_tablename = TB_PRE."witkey_task_plan";	}	public function getPlan_id(){		return $this->_plan_id ;	}	public function getBid_id(){		return $this->_bid_id ;	}	public function getTask_id(){		return $this->_task_id ;	}	public function getPlan_title(){		return $this->_plan_title ;	}	public function getPlan_desc(){		return $this->_plan_desc ;	}	public function getPlan_step(){		return $this->_plan_step ;	}	public function getPlan_amount(){		return $this->_plan_amount ;	}	public function getPlan_status(){		return $this->_plan_status ;	}	public function getStart_time(){		return $this->_start_time ;	}	public function getEnd_time(){		return $this->_end_time ;	}	public function getOver_time(){		return $this->_over_time ;	}	public function getWhere(){		return $this->_where ;	}	public function getCache_config() {		return $this->_cache_config;	}	public function setPlan_id($value){		$this->_plan_id = $value;	}	public function setBid_id($value){		$this->_bid_id = $value;	}	public function setTask_id($value){		$this->_task_id = $value;	}	public function setPlan_title($value){		$this->_plan_title = $value;	}	public function setPlan_desc($value){		$this->_plan_desc = $value;	}	public function setPlan_step($value){		$this->_plan_step = $value;	}	public function setPlan_amount($value){		$this->_plan_amount = $value;	}	public function setPlan_status($value){		$this->_plan_status = $value;	}	public function setStart_time($value){		$this->_start_time = $value;	}	public function setEnd_time($value){		$this->_end_time = $value;	}	public function setOver_time($value){		$this->_over_time = $value;	}	public function setWhere($value){		$this->_where = $value;	}	public function setCache_config($_cache_config) {		$this->_cache_config = $_cache_config;	}	public  function __set($property_name, $value) {		$this->$property_name = $value;	}	public function __get($property_name) {		if (isset ( $this->$property_name )) {			return $this->$property_name;		} else {			return null;		}	}	function create_keke_witkey_task_plan(){		$data =  array();		if(!is_null($this->_plan_id)){			$data['plan_id']=$this->_plan_id;		}		if(!is_null($this->_bid_id)){			$data['bid_id']=$this->_bid_id;		}		if(!is_null($this->_task_id)){			$data['task_id']=$this->_task_id;		}		if(!is_null($this->_plan_title)){			$data['plan_title']=$this->_plan_title;		}		if(!is_null($this->_plan_desc)){			$data['plan_desc']=$this->_plan_desc;		}		if(!is_null($this->_plan_step)){			$data['plan_step']=$this->_plan_step;		}		if(!is_null($this->_plan_amount)){			$data['plan_amount']=$this->_plan_amount;		}		if(!is_null($this->_plan_status)){			$data['plan_status']=$this->_plan_status;		}		if(!is_null($this->_start_time)){			$data['start_time']=$this->_start_time;		}		if(!is_null($this->_end_time)){			$data['end_time']=$this->_end_time;		}		if(!is_null($this->_over_time)){			$data['over_time']=$this->_over_time;		}		return $this->_plan_id = $this->_db->inserttable($this->_tablename,$data,1,$this->_replace);	}	function edit_keke_witkey_task_plan(){		$data =  array();		if(!is_null($this->_plan_id)){			$data['plan_id']=$this->_plan_id;		}		if(!is_null($this->_bid_id)){			$data['bid_id']=$this->_bid_id;		}		if(!is_null($this->_task_id)){			$data['task_id']=$this->_task_id;		}		if(!is_null($this->_plan_title)){			$data['plan_title']=$this->_plan_title;		}		if(!is_null($this->_plan_desc)){			$data['plan_desc']=$this->_plan_desc;		}		if(!is_null($this->_plan_step)){			$data['plan_step']=$this->_plan_step;		}		if(!is_null($this->_plan_amount)){			$data['plan_amount']=$this->_plan_amount;		}		if(!is_null($this->_plan_status)){			$data['plan_status']=$this->_plan_status;		}		if(!is_null($this->_start_time)){			$data['start_time']=$this->_start_time;		}		if(!is_null($this->_end_time)){			$data['end_time']=$this->_end_time;		}		if(!is_null($this->_over_time)){			$data['over_time']=$this->_over_time;		}		if($this->_where){			return $this->_db->updatetable($this->_tablename,$data,$this->getWhere());		}		else{			$where = array('plan_id' => $this->_plan_id);			return $this->_db->updatetable($this->_tablename,$data,$where);		}	}	function query_keke_witkey_task_plan($is_cache=0, $cache_time=0){		if($this->_where){			$sql = "select * from $this->_tablename where ".$this->_where;		}		else{			$sql = "select * from $this->_tablename";		}		if ($is_cache) {			$this->_cache_config ['is_cache'] = $is_cache;		}		if ($cache_time) {			$this->_cache_config ['time'] = $cache_time;		}		if ($this->_cache_config ['is_cache']) {			if (CACHE_TYPE) {				$keke_cache = new keke_cache_class ( CACHE_TYPE );				$id = $this->_tablename . ($this->_where?"_" .substr(md5 ( $this->_where ),0,6):'');				$data = $keke_cache->get ( $id );				if ($data) {					return $data;				} else {					$res = $this->_dbop->query ( $sql );					$keke_cache->set ( $id, $res,$this->_cache_config['time'] );					$this->_where = "";					return $res;				}			}		}else{			$this->_where = "";			return  $this->_dbop->query ( $sql );		}	}	function count_keke_witkey_task_plan(){		if($this->_where){			$sql = "select count(*) as count from $this->_tablename where ".$this->_where;		}		else{			$sql = "select count(*) as count from $this->_tablename";		}		$this->_where = "";		return $this->_dbop->getCount($sql);	}	function del_keke_witkey_task_plan(){		if($this->_where){			$sql = "delete from $this->_tablename where ".$this->_where;		}		else{			$sql = "delete from $this->_tablename where plan_id = $this->_plan_id ";		}		$this->_where = "";		return $this->_dbop->execute($sql);	}}?>