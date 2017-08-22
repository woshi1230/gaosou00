<?php exit;?>
<sql>
	<time>2016-10-12 11:59:23</time>
	<ip>0.0.0.0</ip>
	<user>ywb2b</user>
	<php>/ywb2b_v02/ajax.php</php>
	<querystring></querystring>
	<message>		<query>SELECT a.username,b.content FROM yw_company as a left join yw_company_data as b on a.userid = b.userid WHERE userid =1 </query>
		<errno>0</errno>
		<error>Column 'userid' in where clause is ambiguous</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>