$(function(){
	var objCkbItem = $("input[name^='txt_']");
	objCkbItem.click(function(){
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
	$('#payitem-costs').text(tatalPrice);
	$('#hdn-total-costs').val(tatalPrice);
	$('#total-costs').text(tatalPrice+taskCosts);
}

