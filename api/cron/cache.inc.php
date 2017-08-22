<?php
defined('IN_GAOSOU') or exit('Access Denied');
if($CFG['cache'] == 'file') $dc->expire();
?>