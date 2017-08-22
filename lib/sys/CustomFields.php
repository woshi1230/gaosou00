<?php
class CustomFields {
	private $_tbname ;
	private $_tbfield;
	private $_tbtype ;
	private $_tbdefault ='0';
	private $_tbcomment = '';
	public function setName($tbname){
		$this->_tbname = TB_PRE.$tbname;
	}
	public function setField($tbfield){
		$this->_tbfield =$tbfield;
	}
	public function setType($tbtype){
		$this->_tbtype = $tbtype;
	}
	public function setDefault($tbdefault){
		$this->_tbdefault = $tbdefault;
	}
	public function setComment($tbcomment){
		$this->_tbcomment = $tbcomment;
	}
	public function addFields() {
		if(!$this->isFieldsExsits()){
			db_factory::execute("ALTER TABLE ".$this->_tbname." ADD ".$this->_tbfield." ".$this->_tbtype." ".$this->_tbdefault."  COMMENT '".$this->_tbcomment."'");
			return true;
		}
		return false;
	}
	public function delFields() {
		if($this->isFieldsExsits()){
			db_factory::execute("ALTER TABLE ".$this->_tbname." DROP ".$this->_tbfield);
			return true;
		}
		return false;
	}
	public function isFieldsExsits() {
		$col_info = db_factory::query("show COLUMNS FROM ".$this->_tbname." WHERE Field='".$this->_tbfield."' ");
		if($col_info){
			return true;
		}
		return false;
	}
}
?>