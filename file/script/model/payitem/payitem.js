

$(function(){
/*	var objItem = $("input[name^='txt_']");
	objItem.keyup(function(){
		var arrPrice = new Array();
		var intNum = 0;
		objItem.each(function(i,obj){
			var objVal= parseInt($(obj).val())+0;
			if(isNaN(objVal)||objVal ==''){
				objVal = 0;
			}
			intNum = parseInt(intNum)+objVal;
			var objPrice = $(obj).attr('data-unit-price');
			if(isNaN(objPrice)||objPrice ==''){
				objPrice = 0;
			}
			arrPrice[i] = objPrice*objVal;
		});
		var tatalPrice = 0;
		for(i in arrPrice){
			tatalPrice += arrPrice[i];
		}
		$('#payitem-costs').text(tatalPrice);
		if(intNum>0){
			$("#btn-payitempay").removeAttr('disabled');
		}

	});*/

	var objCkbItem = $("input[name^='txt_']");
	var objCkbItem1 = $("input[name^='text_']");
/*	objCkbItem1.click(function(){
		$('#balance_pay').addClass('hidden');
	});
	objCkbItem1.change(function(){
		$('#balance_pay').addClass('hidden');
	});
	objCkbItem1.key(function(){
		$('#balance_pay').addClass('hidden');
	});*/
	objCkbItem1.live('click change mousedown',function(){
		$('#balance_pay').addClass('hidden');
	});
	/*$('#tr_balace').live('click',function(){
		$('#balance_pay').addClass('hidden');
	});
	$('.table').live('click',function(){
		$('#balance_pay').addClass('hidden');
	});	*/
	
	objCkbItem.click(function(){
		$('#balance_pay').addClass('hidden');
		var thisCode = $(this).attr('data-code');
		if(thisCode =='tasktop' || thisCode =='goodstop'){
			if($(this).is(':checked')){
				$(".div_"+thisCode).removeClass('hidden');
			}else{
				$(".div_"+thisCode).addClass('hidden');
				$(".div_"+thisCode).parent('div').closest('div').removeClass('has-error');
				$(".div_"+thisCode).siblings().remove();
			}
		}
		
		sumTotal(objCkbItem);
	});
	var objTextItem = $("input[name^='text_']");
	objTextItem.keyup(function(){
		sumTotal(objCkbItem);
	});
});

function sumTotal(objItem){
	var tatalPrice = 0;
	var taskCosts = parseFloat($('#task-costs').text());
	var arrPrice = new Array();
	objItem.each(function(i,obj){
		if($(obj).is(':checked')){
			var objPrice= parseFloat($(obj).attr('data-unit-price'));
			var objCode= $(obj).attr('data-code');
			if(isNaN(objPrice)||objPrice ==''){
				objPrice = 0;
			}
			if(objCode =='tasktop' || objCode =='goodstop'){
				var buyDays = parseInt($("#text_"+objCode).val());
				if(isNaN(buyDays)||buyDays ==''){
					buyDays = 0;
				}
				objPrice = objPrice * buyDays;
			}
			arrPrice[i] = objPrice;
		}
	});
	for(i in arrPrice){
		tatalPrice += arrPrice[i];
	}
	var str=objItem.is(':checked');
	if(str){
		$('#check_balance').removeClass('hidden');
		$("#blance_total").removeClass('hidden');
		$('#clo_se1').addClass('hidden');
		$('#payitem-costs').text(tatalPrice);	
		$("#btn-payitempay").removeAttr('disabled');
	}else{
		$('#clo_se1').removeClass('hidden');
		$("#blance_total").addClass('hidden');
		$('#check_balance').addClass('hidden');
	}
	$('#hdn-total-costs').val(tatalPrice);
	$('#total-costs').text(tatalPrice+taskCosts);
	if(tatalPrice){
		$("#btn-payitempay").removeAttr('disabled');
	}
}