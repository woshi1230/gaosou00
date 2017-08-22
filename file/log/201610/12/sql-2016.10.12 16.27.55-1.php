<?php exit;?>
<sql>
	<time>2016-10-12 16:27:55</time>
	<ip>0.0.0.0</ip>
	<user>ywb2b</user>
	<php>/ywb2b_v02/index.php</php>
	<querystring>homepage=ywzdh&amp;file=task</querystring>
	<message>		<query>SELECT COUNT(DISTINCT b.task_id) AS num FROM yw_witkey_task AS b LEFT JOIN  yw_witkey_task_work AS a on   a.task_id = b.task_id WHERE a.username='ywzdh' LIMIT 0,1</query>
		<errno>0</errno>
		<error>MySQL server has gone away</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>