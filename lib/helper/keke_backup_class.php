<?php
class keke_backup_class {
	static function run_backup() {
		global $_lang;
		set_time_limit(0);
		ini_set('memory_limit','1024M');
		$output = array();
		$db_factory = new db_factory ();
		$tables = $db_factory->query ( " show table status from `".DBNAME."`");
		$temp_arr = array ();
		foreach ( $tables as $v ) {
			if (substr ( $v [Name], 0, strlen ( TB_PRE ) ) == TB_PRE) {
				$temp_arr [] = $v;
			}
		}
		$tables = $temp_arr;
		$sqlmsg = '';
		foreach ( $tables as $tablesarr ) {
			$table_name = $tablesarr ['Name'];
			$table_type = $tablesarr ['Type'];
			$result = $db_factory->query ( "show fields from " . $table_name );
			$sqlmsg .= "#" . $_lang['table_name'] . "：<" . $table_name . ">\n";
			$sqlmsg .= "DROP TABLE IF EXISTS `" . $table_name . "`;\n";
			$createtable = $db_factory->query ( "SHOW CREATE TABLE " . $table_name );
			$sqlmsg.=$createtable[0]['Create Table']. " ;\n";
			$result = $db_factory->query ( "show fields from " . $table_name );
			foreach ( $result as $fileds ) {
				$fields [] = "`" . $fileds ['Field'] . "`";
			}
			$field = join ( ",", $fields );
			$sql_insert= self::querySelect($table_name,$field,$result);
			if($sql_insert !== false){
				$sqlmsg.=$sql_insert;
			}
			unset ( $fields ); 
			$output[] = str_replace(TB_PRE.'witkey_', '**********************',$table_name);
		}
		$sqlmsg .= "\n"; 
		$path = S_ROOT . './data/backup/backup_' . time () . '_' . DBNAME . ".sql";
		keke_tpl_class::swritefile ( $path, $sqlmsg );
		kekezu::admin_system_log ( $_lang['backup_database'] . '' . "backup_" . time () . '_' . DBNAME . ".sql" );
		file_exists ( $path ) and kekezu::echojson('',1,$output) or kekezu::echojson('',0,$output);
		die();
	}
	static function querySelect($table_name,$field,$tablefields){
		$db_factory = new db_factory ();
		$fori = 0;
		$forlimit= 100;
		$sqlCount = $db_factory->get_count( "select count(*) from " . $table_name );
		if(!$sqlCount){
			return false;
		}
		$tabledump = '';
		$numfields = count($tablefields);
		while ($fori<=$sqlCount){
			$sql = $db_factory->query ( "select * from " . $table_name." limit ".$fori.",".$forlimit );
			foreach ( $sql as $r ) {
				$row = array_values($r);
				$sqlmsg =$comma= '';
				for($i = 0; $i < $numfields; $i++) {
					$sqlmsg .= $comma.(!empty($row[$i]) && (self::strexists($tablefields[$i]['Type'], 'char') || self::strexists($tablefields[$i]['Type'], 'text')) ? '0x'.bin2hex($row[$i]) : '\''.mysql_escape_string($row[$i]).'\'');
					$comma = ',';
				}
				$tabledump .= " INSERT INTO " . $table_name . "  VALUES(".$sqlmsg.") ;\n";
			}
			$fori+=$forlimit;
		}
		return $tabledump;
	}
	static function strexists($haystack, $needle) {
		return !(strpos($haystack, $needle) === FALSE);
	}
}