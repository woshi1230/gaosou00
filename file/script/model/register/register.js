

$(function(){
	$("#getPasswordCode").focus(function(){
		$("#show_secode_menu_content").removeClass("hidden");
	});
	//注册验证
	$('#registerForm').scojs_valid({
		rules: {
			account  : ['not_empty',{'min_length': 2},{'max_length': 20}],
			email  : ['not_empty','email'],
			password : ['not_empty', {'min_length': 6}],
			confirmPassword :[{matches: 'password'}],
			code:['not_empty']
		},
		messages: {
			account: {
				not_empty: "请输入注册账号",
				min_length: "账号不少于2个字符",
				max_length: "账号不能超过20个字符"
			},
			email: {
				not_empty: "请输入邮箱",
				email: "请输入正确的邮箱"
			},

			password: {
				not_empty: "请输入登陆密码，区分大小写",
				min_length: "密码太短了，至少要6位哦"
			},
			confirmPassword:{
				matches: "两次输入密码不一致"
			},
			code:{
				not_empty: "请输入验证码"
			}
		},
		wrapper:'.form-group'
			,onSuccess: function(response, validator, $form) {
				if(response.data){
					tipsOp(response.data,response.status);
				}

				if(response.url){
					setTimeout(function(){window.location.href=response.url;},3000);
				}
			}
	});
	
	//Oauth注册
	$('#OauthregisterForm').scojs_valid({
		rules: {
			account  : ['not_empty',{'min_length': 2},{'max_length': 20}],
			password : ['not_empty', {'min_length': 6}],
			confirmPassword :[{matches: 'password'}],
			code:['not_empty']
		},
		messages: {
			account: {
				not_empty: "请输入注册账号",
				min_length: "账号不少于2个字符",
				max_length: "账号不能超过20个字符"
			},

			password: {
				not_empty: "请输入登陆密码，区分大小写",
				min_length: "密码太短了，至少要6位哦"
			},
			confirmPassword:{
				matches: "两次输入密码不一致"
			},
			code:{
				not_empty: "请输入验证码"
			}
		},
		wrapper:'.form-group'
			,onSuccess: function(response, validator, $form) {
				if(response.data){
					tipsOp(response.data,response.status);
				}

				if(response.url){
					setTimeout(function(){window.location.href=response.url;},3000);
				}
			}
	});
	//登录验证
	$('#loginForm').scojs_valid({
		rules: {
			account  : ['not_empty',{'min_length': 2},{'max_length': 20}],
			password : ['not_empty', {'min_length': 6}],
			code:['not_empty']
		},
		messages: {
			account: {
				not_empty: "请输入账号",
				min_length: "账号不少于2个字符",
				max_length: "账号不能超过20个字符"
			},
			password: {
				not_empty: "请输入登陆密码，区分大小写",
				min_length: "密码太短了，至少要6位哦"
			},
			code:{
				not_empty: "请输入验证码"
			}
		},
		wrapper:'.form-group'
			,onSuccess: function(response, validator, $form) {
				tipsOp(response.data,response.status);
				if(response.url){
					window.location.href=response.url;
					//setTimeout(function(){window.location.href=response.url;},3000);
				}
			}
	});
	//找回密码第一步
	$('#getForm1').scojs_valid({
		rules: {
			account  : ['not_empty',{'min_length': 1},{'max_length': 50}],
			getPasswordCode:['not_empty']
		},
		messages: {
			account: {
				not_empty: "请输入账号",
				min_length: "账号不少于2个字符",
				max_length: "账号不能超过20个字符"
			},
			getPasswordCode:{
				not_empty: "请输入验证码"
			}
		},
		wrapper:'.form-group'
			,onSuccess: function(response, validator, $form) {
				//tipsOp(response.data);
				if(response.url){
					setTimeout(function(){window.location.href=response.url;},2000);
				}
			}
		,onFail: function(response, validator, $form) {
			tipsOp(response.data,response.status);
		    if(response.url){
		    	setTimeout(function(){window.location.href=response.url;},2000);
			}
	}
	});
	//找回密码第二步
	$('#getForm2').scojs_valid({
		rules: {
			valid_code  : ['not_empty',{'exact_length': 6}]
		},
		messages: {
			valid_code: {
				not_empty: "请输入账号",
				exact_length: "验证码格式错误"
			}
		},
		wrapper:'.form-group'
		,onSuccess: function(response, validator, $form) {
				if(response.url){
					window.location.href=response.url;
				}
		}
	});
	//重置密码
	$('#pwdResetForm').scojs_valid({
		rules: {
			newpwd  : ['not_empty',{'min_length': 6},{'max_length': 16}],
			newpwd2  :[{matches: 'newpwd'}],
		},
		messages: {
			newpwd: {
				not_empty: "请输入账号",
				min_length: "密码长度6~16位,字母区分大小写",
				max_length: "密码长度6~16位,字母区分大小写"
			},
			newpwd2:{
				matches: "您输入的密码与确认密码不一致"
			}
		},
		wrapper:'.form-group'
			,onSuccess: function(response, validator, $form) {
				tipsOp(response.data,response.status);
				if(response.url){
					setTimeout(function(){window.location.href=response.url;},2000);
				}
			}
	});
});
