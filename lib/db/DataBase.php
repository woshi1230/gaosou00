<?php
define('D_ROOT', 'sqlite');
abstract class DataBase {
//	static protected $dbhost = DBHOST;
	static protected $dbhost = "";
	static protected $dbname = "";
	static protected $dbuser = "";
	static protected $dbpass = "";
	static protected $dbcharset = "";
	static protected $datapath = D_ROOT;
	static protected $tablepre = TB_PRE;
	abstract   function  dbConnection();
	abstract   function  query($sql);
	abstract   function  insert_id($sql);
	abstract   function  getCount($sql);
}
?>