<?php
class OAuthClass {
	public static function factory($type) {
		$filename = S_ROOT . 'include/oauth/' . ucfirst($type) . 'OAuthClass.php';
		if (file_exists($filename)) {
			require S_ROOT . 'include/oauth/OAuthBase.php';
			require $filename;
			$classname = ucfirst($type).'OAuthClass';
			return new $classname ($type);
		} else {
			exit( 'obj not found' );
		}
	}
}
?>