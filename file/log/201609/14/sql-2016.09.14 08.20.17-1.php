<?php exit;?>
<sql>
	<time>2016-09-14 08:20:17</time>
	<ip>0.0.0.0</ip>
	<user>ywb2b</user>
	<php>/ywb2b_v02/member/witkey.php</php>
	<querystring>action=waitpay</querystring>
	<message>		<query>SELECT COUNT(*) as amount FROM yw_witkey_task WHERE buyer='ywb2b' AND status=0 LIMIT 0,1</query>
		<errno>0</errno>
		<error>Unknown column 'buyer' in 'where clause'</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>