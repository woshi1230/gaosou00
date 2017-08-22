

$(function(){
	//第一步
	$('#pubTaskFormstep1').scojs_valid({
		rules:{
			txt_task_cash: ['not_empty','decimal',{regex: /^((\d{1,8}\.\d{1,2})|(\d{1,8}))$/}],
			txt_task_day:['not_empty']

		},
		messages: {
			txt_task_cash: {
				not_empty: "请输入您的预算",
				decimal:'输入格式不正确',
				regex:'你输入的预算只能从0-99999999.99元'
			},
			txt_task_day:{
				not_empty: "请选择结束日期"
			}
		},
		wrapper:'.form-group'
		,onSuccess: function(response, validator, $form) {
			tipsUser(response.data,response.status);
			if(response.url){
				window.location.href=response.url;
			}
		}
	});
	//第二步
	//$('#pubTaskFormstep2').scojs_valid({
	//	rules: {
	//		indus_pid:	['not_empty'],
	//		indus_id: 	['not_empty'],
	//		txt_title:	['not_empty',{min_length:2}, {max_length:50} ],
	//		tar_content:['not_empty',{min_length:20},{max_length:65565} ],
	//		txt_mobile:	['not_empty',{min_length:11},{max_length:11},'digit' ]
	//	},
	//	messages: {
	//		indus_pid: {
	//			not_empty : "请选择父行业"
	//		},
	//		indus_id:{
	//			not_empty : "请选择子行业"
	//		},
	//		txt_title:{
	//			not_empty : "请输入标题名称",
	//			min_length: "标题名称最少2字符",
	//			max_length: "标题名称最多50字符"
	//		},
	//		tar_content:{
	//			not_empty : "请输入需求描述",
	//			min_length: "需求描述最少20字符",
	//			max_length: "需求描述最多65565字符"
	//		},
	//		txt_mobile:{
	//			not_empty : "请输入手机号码",
	//			digit     : "请输入正确的手机号码",
	//			min_length: '请检查手机号码是否输入正确',
	//			max_length: '请检查手机号码是否输入正确'
	//		}
	//	},
	//	wrapper:'.form-group'
	//	,onSuccess: function(response, validator, $form) {
	//		tipsUser(response.data,response.status);
	//		if(response.url){
	//			window.location.href=response.url;
	//		}
	//	}
	//});
	//第三步
	$('#pubTaskFormstep3').scojs_valid({
		rules: {},
		messages: {},
		wrapper:'.form-group'
		,onSuccess: function(response, validator, $form) {
			tipsUser(response.data,response.status);
			if(response.url){
				window.location.href=response.url;
			}
		}
	});

	//查看更多
	$("#viewMoreContent").click(function(){
		if($(this).text() == '查看更多'){
			$("#fullContent").removeClass('hidden');
			$("#partContent").addClass('hidden');
			$(".release-detail").css("max-height", "none");
			$(this).text('收起更多');
		}else{
			$("#fullContent").addClass('hidden');
			$("#partContent").removeClass('hidden');
			$(".release-detail").css("max-height", "12.5em");
			$(this).text('查看更多');
		}
	});
})