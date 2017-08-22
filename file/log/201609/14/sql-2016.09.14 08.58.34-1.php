<?php exit;?>
<sql>
	<time>2016-09-14 08:58:34</time>
	<ip>0.0.0.0</ip>
	<user>ywb2b</user>
	<php>/ywb2b_v02/member/witkey.php</php>
	<querystring>action=index</querystring>
	<message>		<query>SELECT COUNT(*) as amount FROM yw_witkey_task_work WHERE seller='ywb2b' AND status=4 AND buyer_star=0 LIMIT 0,1</query>
		<errno>0</errno>
		<error>Unknown column 'seller' in 'where clause'</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>