/**
 * 举报维权
 */
function changeBanner(id){
	var url = 'index.php?do=ajax&view=banner&id='+id;
	var modal = $.scojs_modal({
		remote : url,
		title : '个性化设置'
	});
	modal.show();
}

/**
 * 关店 
*/
function closeshop(suid){
		confirmOp('<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 确定关闭店铺吗？商品会一同下架!</div>',
				function(){
			//formSubmit('index.php?do=seller&closeshop=1&id='+suid,'url');
			$.post("index.php?do=seller&closeshop=1&id="+suid,function(json){
				tipsOp(json.data, json.status);
				if (json.data) {
					setTimeout(function() {
						window.location.href = "index.php?do=seller&id="+suid;
					}, 3000);
				}
			},'json');

		},false);
}
function openshop(suid){
	$.post("index.php?do=seller&openshop=1&id="+suid,function(json){
		tipsOp(json.data,json.status);
		if(json.data){
			setTimeout(function(){
				window.location.href="index.php?do=seller&id="+suid;
			},3000)
		}
	},'json');
}
function changeShow(suid){
			$.post("index.php?do=seller&changeShow=1",{"id":suid},function(json){
				tipsOp(json.data,json.status);
				if (json.data) {
					setTimeout(function() {
						window.location.href = "index.php?do=seller&id="+suid;
					}, 1000);
				}
			},'json');
}
function changeHide(suid){
	confirmOp('<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> 确定在服务商列表中隐藏店铺么？</div>',
		function(){
			$.post("index.php?do=seller&changeHide=1",{"id":suid},function(json){
				tipsOp(json.data,json.status);
				if (json.data) {
					setTimeout(function() {
						window.location.href = "index.php?do=seller&id="+suid;
					}, 1000);
				}
			},'json');
		},false);
}