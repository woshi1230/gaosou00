/**
 * 完工上传附件删除的Js操作
 */
$(function(){
	  var obj = $("a[data-class='delete-completefile']");
	  obj.on("click",function(){
		  var fileid = $(this).attr('data-file-id');
		  var strUrl = 'index.php?do=taskhandle&op=workover&taskId='+taskId;
		  $.post(strUrl,{action:'deleteFile',fileid:fileid},function(json){
			  if(json.status =='1'){
				  $("li[data-file-id='"+json.data.fileid+"']").remove();
				  $("#file_id").val('');
			  }
		  },'json');
	  });
});



/** 查看联系方式*/
function getContact(){
	var url = 'index.php?do=taskhandle&op=getContact&taskId='+taskId;
	var modal = $.scojs_modal({
		remote : url,
		title : '查看联系方式'
	});
	modal.show();
}
/** 放弃投标*/
   function giveUp(){
	   if (checkLogin()) {
	   confirmOp('确认放弃投标？', function(){
		   var url =  "index.php?do=taskhandle&op=workGiveup&taskId="+taskId;
		   formSubmit(url,'url');
	   });
	  }
   }
/** 发送提醒*/
function sendNotice(type){
	if (checkLogin()) {
		var url = "index.php?do=taskhandle&op=sendNotice&type=" + type+"&taskId="+taskId;
		formSubmit(url,'url');return false;
	}
}
/** 淘汰稿件*/
function workCancel(){
	if (checkLogin()) {
		 confirmOp('确认淘汰此稿件？', function(){
			   var url =  "index.php?do=taskhandle&op=workcancel&taskId="+taskId;
			   formSubmit(url,'url');
		   });
	}
}
/** 赏金托管*/
function taskHost(taskId){
	if (checkLogin()) {
	var url = 'index.php?do=taskhandle&op=taskHost&taskId='+taskId;
	var modal = $.scojs_modal({
		remote : url,
		title : '托管赏金'
	});
	modal.show();
	}
}

/** 确认完工*/
function workOver(modify,taskId){
	if (checkLogin()) {
		var url = 'index.php?do=taskhandle&op=workover&taskId='+taskId+'&modify='+modify;
		var modal = $.scojs_modal({
			remote : url,
			title : '确认完工'
		});
		modal.show();
	}
}
/** 工作验收*/
function taskAccept(taskId){
	if (checkLogin()) {
		   confirmOp('确认工作验收？', function(){
			   var url =  "index.php?do=taskhandle&op=taskAccept&taskId="+taskId;
			   formSubmit(url,'url');
		   });
	}
}
//支付托管
$(function(){
	$('#hostCashForm').scojs_valid({
	    rules:{
			zfpwd:['not_empty',{'min_length': 2}]
	    },
	    messages: {
	    	zfpwd: {
				not_empty: "请输入支付密码，区分大小写",
				min_length: "密码太短了"
			}
	    },
	    wrapper:'.form-group'
	    ,onSuccess: function(response, validator,$form) {
	    	//关闭举报弹窗，延迟提示
	    	$('.close').trigger('click');
	    	var stt = setTimeout(function(){
	    		tipsOp(response.data,response.status);
	    		clearTimeout(stt);
	    		if(response.url){
	    			setTimeout(function(){window.location.href=response.url;},2000);
	      	  	}
	    	},1000);
	    }
	});
	
});
