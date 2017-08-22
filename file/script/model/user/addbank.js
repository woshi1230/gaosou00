$(function(){

	//认证中心--银行认证--添加新账户
	$('#editAddBankInfoForm').scojs_valid({
		rules: {
			txt_name  : ['not_empty',{'max_length': 30}],
			bank_full_name  : ['not_empty',{'max_length': 50}],
			card_num  : ['not_empty','credit_card'],
			card_num2 :[{matches: 'card_num'}]
		},
		messages: {
			txt_name: {
				not_empty: '请输入真实姓名',
				max_length: '真实姓名太长了哦'
			},
			bank_full_name: {
				not_empty: "请输入开户行名称",
				max_length: "开户行名称太长了哦"
			},
			card_num: {
				not_empty: "请输入银行卡号",
				credit_card: "银行卡号格式不正确"
			},
			card_num2:{
				matches: "两次输入银行卡号不一致"
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
	//企业
	$('#editAddCompanyBankInfoForm').scojs_valid({
		rules: {
			conpany_name  : ['not_empty',{'max_length': 30}],
			bank_full_name  : ['not_empty',{'max_length': 50}],
			card_num  : ['not_empty','digit',{'max_length': 21},{'min_length': 21}],
			card_num2 :[{matches: 'card_num'}]
		},
		messages: {
			conpany_name: {
				not_empty: '请输入企业名称',
				max_length: '企业名称太长了哦'
			},
			bank_full_name: {
				not_empty: "请输入开户行名称",
				max_length: "开户行名称太长了哦"
			},
			card_num: {
				not_empty: "请输入银行卡号",
				digit: "请输入数字",
				max_length: "请输入21位数字",
				min_length: "请输入21位数字"
			},
			card_num2:{
				matches: "两次输入银行卡号不一致"
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
});
