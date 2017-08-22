$(function() {


	//线下充值表单提交
	$('#editOffpayForm').scojs_valid({
	    rules: {
	    	pay_money:['not_empty'],
	    	pay_info:['not_empty']
	    },
	    messages: {
	    	pay_money: {
				not_empty: "请输入充值金额"
			},
			pay_info:{
				not_empty: "请输入充值信息"
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
	//提现安全码验证表单提交
	$('#secodeForm').scojs_valid({
	    rules: {
	    	sec_code:['not_empty']
	    },
	    messages: {
	    	sec_code: {
				not_empty: "请输入安全码"
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
	//提现第一步提交
	$('#withdrawStep1Form').scojs_valid({
	    rules: {
	    	intWithdrawCash:['not_empty','decimal',{regex: /^((\d{1,8}\.\d{1,2})|(\d{1,8}))$/}]
	    },
	    messages: {
	    	intWithdrawCash: {
				not_empty: "请输入提现金额",
				decimal:'请正确输入提现金额',
				regex:'你输入的预算只能从0-99999999.99元'
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
	//提现第三步线上提现方式提交
	$('#onStep3Form').scojs_valid({
	    rules: {
	    	pay_account:['not_empty'],
	    	pay_username:['not_empty']
	    },
	    messages: {
	    	pay_account: {
				not_empty:"请输入账号"
			},
			pay_username:{
				not_empty:"请输入用户名"
			}
	    },
	    wrapper:'.form-group'
	    ,onSuccess: function(response, validator, $form) {
	    	$(this).attr('disabled','disabled').addClass('disabled');
	    	tipsOp(response.data,response.status);
	    	  if(response.url){
	    		  setTimeout(function(){window.location.href=response.url;},3000);
	    	  }
	    }
	});
	//提现第三步线下提现方式提交
	$('#offStep3Form').scojs_valid({
	    rules: {
	    	pay_amount:['not_empty'],
	    	pay_username:['not_empty']
	    },
	    messages: {
	    	pay_amount: {
				not_empty:"请输入卡号"
			},
			pay_username:{
				not_empty:"请输入用户名"
			}
	    },
	    wrapper:'.form-group'
	    ,onSuccess: function(response, validator, $form) {
	    	tipsOp(response.data,response.status);
	    	  if(response.url){
	    		  setTimeout(function(){window.location.href=response.url;},3000);
	    	  }
	    }
	});

	//提现第三步线下提现方式提交
	$('#onlineRechargeForm').scojs_valid({
	    rules: {
	    	floatRecharge:['not_empty','numeric',{regex: /^((\d{1,8}\.\d{1,2})|(\d{1,8}))$/}]
	    },
	    messages: {
	    	floatRecharge: {
				not_empty:"充值金额不能空",
				numeric:"充值金额必须填写数字类型",
				regex:'你输入的预算只能从0-99999999.99元'
			}
	    },
	    wrapper:'.form-group'
	    ,onSuccess: function(response, validator, $form) {
	    	  //tipsOp(response.data,response.status);
	    	  if(response.url){
					window.location.href=response.url;
	    	  }
	    }
	});


})


//提现第二步，选择提现方式
function userWithdraw(){
	 var paymode = 'online';;
    if($("div#tab_cont_2").hasClass("active")){
		paymode  = 'offline';
	 }
   switch (paymode) {
       case "online":
           var strPayType = $(":radio[name='online']:checked").val();
           location.href = strUrl+"&strStep=3&ver=1&paymode=" + paymode + "&pay_type=" + strPayType + "&intWithdrawCash="+withdrawCash;
           break;
       case "offline":
           var strPayType = $(":radio[name='offline']:checked").val();
			var strPayBank = $(":radio[name='offline']:checked").val();
           location.href = strUrl+"&strStep=3&ver=1&paymode=" + paymode + "&pay_type=" + strPayType + "&pay_bank="+strPayBank+"&intWithdrawCash="+withdrawCash;
           break;
   }
}
