/*
 [GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
 This is NOT a freeware, use is subject to license.txt
 */
var _p = 0;
function AutoTab() {
	var c;
	Dd('trades').onmouseover = function() {_p = 1;}
	Dd('trades').onmouseout = function() {_p = 0;}
	if(_p) return;
	if(!Dd('trade_t_'+i)) return;
	for(var i = 1; i < 4; i++) { if(Dd('trade_t_'+i).className == 'tab_2') {c = i;} }
	c++;
	if(c > 3) c = 1;
	Tb(c, 3, 'trade', 'tab');
}
if(Dd('trades') != null) window.setInterval('AutoTab()',5000);
function ipad_tip_close() {
	Dh('ipad_tips');
	set_local('ipad_tips', 1);
}
if(Dd('ipad_tips') != null && UA.match(/(iphone|ipad|ipod)/i) && get_local('ipad_tips') != 1) {
	Ds('ipad_tips');
	Dd('ipad_tips').innerHTML = '<div class="ipad_tips_logo"><img src="'+DTPath+'apple-touch.png" width="50" height="50" alt=""/></div><div class="ipad_tips_text"><strong>把本站添加至主屏幕</strong><br/>请点击工具栏上的<span class="ipad_tips_ico1"></span>或者<span class="ipad_tips_ico2"></span>并选择“添加书签”或者“添加至主屏幕”便于下次直接访问。</div><div class="ipad_tips_hide"><a href="javascript:ipad_tip_close();" class="ipad_tip_close" title="关闭并不再提示">&nbsp;</a></div><div class="c_b"></div>';
}

function select_mod() {
	$('#selectMod').attr('size', $("#selectMod")[0].length);
}
function change_mod() {
	$('#selectMod').attr('size', 1);
	setModule($("#selectMod")[0].value, '1');
}
function select_mod2(elem) {
	if (document.createEvent) {
		var e = document.createEvent("MouseEvents");
		e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
		elem[0].dispatchEvent(e);
	} else if (element.fireEvent) {
		elem[0].fireEvent("onmousedown");
	}
}
function membPop2(memb) {
	$(memb).popover('toggle');
}

var isOnMenu1 = false;
var isOnMenu2 = false;
var isOnMenu3 = false;
function showCatMenu1(no, name) {
	setTimeout(function(){
		isOnMenu1 = true;
		$(".dorpdown-layer1").css({display: 'block'});
		$(".item-sub1").css({display: 'none'});
		$("#category-item1-"+no).css({display: 'block'});
		$("#path_level0").val(name);
		$(".category-item").css({background: '#fff'});
		$(".category-item:hover").css({background: '#fff'})
	}, 2);
}
function hideCatMenu1() {
	$(".category-item").css({background: '#fff'});
	setTimeout(function(){
		if (!isOnMenu1 && !isOnMenu2) {
			isOnMenu1 = false;
			$(".dorpdown-layer1").css({display: 'none'});
		}
	}, 1);
}

function showCatMenu2(no, name) {
	setTimeout(function(){
		isOnMenu2 = true;
		if (no) {
			$(".dorpdown-layer2").css({display: 'block'});
			$(".item-sub2").css({display: 'none'});
			$("#category-item2-"+no).css({display: 'block'});
			$("#path_level1").val(name);
			$(".category-item1 li").css({background: '#fff'});
			$(".category-item1 li:hover").css({background: '#fff'})
		}
	}, 2);
}
function hideCatMenu2() {
	$(".category-item1 li").css({background: '#fff'});
	setTimeout(function(){
		if (!isOnMenu2 && !isOnMenu3) {
			isOnMenu2 = false;
			$(".dorpdown-layer2").css({display: 'none'});
		}
	}, 1);
}

function showCatMenu3(no, name) {
	setTimeout(function(){
		isOnMenu3 = true;
		$(".dorpdown-layer3").css({display: 'block', border: "1px solid #dddddd"});
		$(".item-sub3").css({display: 'none'});
		$("#category-item3-"+no).css({display: 'block'});
		$("#path_level2").val(name);
		$(".category-item2 li").css({background: '#fff'});
		$(".category-item2 li:hover").css({background: '#f7f7f7'})
	}, 2);
}
function hideCatMenu3() {
	setTimeout(function(){
		if (!isOnMenu3) {
			isOnMenu3 = false;
			$(".dorpdown-layer3").css({display: 'none'});
		}
	}, 1);
}
function closeMenu3() {
	isOnMenu3 = false;
	hideCatMenu3();
	$(".category-item2 li").css({background: '#fff'});
	$(".category-item2 li:hover").css({background: '#f7f7f7'})
}

function selMenu4() {
	$(".category-item3 li").css({background: '#fff'});
	$(".category-item3 li:hover").css({background: '#f7f7f7'})
}

var hover0 = false;
var hover1 = false;
var hover2 = false;
var hover3 = false;
$('.category-down').hover(function() {
	hover0 = true;
	if (!hover1) {
		isOnMenu2 = false;
		$(".dorpdown-layer2").css({display: 'none'});
	}
}, function() {
	hover0 = false;
	setTimeout(function(){
		if (!hover1) {
			isOnMenu1 = false;
			$(".dorpdown-layer1").css({display: 'none'});
		}
	}, 10);
});

$('.dorpdown-layer1 .item-sub1').hover(function() {
	hover1 = true;
	isOnMenu1 = true;
	$("#category-item0-"+$("#path_level0").val()).css({background: '#f7f7f7'});
}, function() {
	hover1 = false;
	isOnMenu1 = false;
	setTimeout(function(){
		if (!isOnMenu1 && !hover0 && !hover2) {
			isOnMenu1 = false;
			$(".dorpdown-layer1").css({display: 'none'});

			isOnMenu2 = false;
			$(".dorpdown-layer2").css({display: 'none'});
		}
	}, 20);
});

$('.dorpdown-layer2 .item-sub2').hover(function() {
	hover2 = true;
	isOnMenu1 = true;
	isOnMenu2 = true;
	$("#item1-"+$("#path_level1").val()).css({background: '#f7f7f7'});
}, function() {
	hover2 = false;
	isOnMenu2 = false;
	setTimeout(function(){
		if (!isOnMenu2 && !hover1 && !hover3) {
			isOnMenu2 = false;
			$(".dorpdown-layer2").css({display: 'none'});

			isOnMenu3 = false;
			$(".dorpdown-layer3").css({display: 'none'});
		}
		if (!hover3) {
			isOnMenu3 = false;
			$(".dorpdown-layer3").css({display: 'none'});
		}
	}, 50);
	setTimeout(function(){
		if (!hover3) {
			setTimeout(function(){
				if (!hover0 && !hover1 && !hover2 && !hover3) {
					isOnMenu1 = false;
					$(".dorpdown-layer1").css({display: 'none'});
				}
			}, 2000);
		}
	}, 2);
});

$('.dorpdown-layer3 .item-sub3').hover(function() {
	hover3 = true;
	isOnMenu2 = true;
	isOnMenu3 = true;
	$("#item2-"+$("#path_level2").val()).css({background: '#f7f7f7'});
}, function() {
	hover3 = false;
	isOnMenu3 = false;
	$(".dorpdown-layer3").css({display: 'none'});
	setTimeout(function(){
		if (!hover2 && !hover3) {
			isOnMenu2 = false;
			$(".dorpdown-layer2").css({display: 'none'});
		}
	}, 1000);
	setTimeout(function(){
		if (!hover0 && !hover1 && !hover2 && !hover3) {
			isOnMenu1 = false;
			$(".dorpdown-layer1").css({display: 'none'});
		}
	}, 2000);
});

function closeCatMenu() {
	isOnMenu1 = false;
	$(".dorpdown-layer1").css({display: 'none'});
	isOnMenu2 = false;
	$(".dorpdown-layer2").css({display: 'none'});
	isOnMenu3 = false;
	$(".dorpdown-layer3").css({display: 'none'});
}

function getRankByCat(catid,catname,level) {
	switch(level)
	{
		case 2:
			catname = $("#path_level0").val() + '/' + catname;
			break;
		case 3:
			catname = $("#path_level0").val() + '/' + $("#path_level1").val() + '/'  + catname;
			break;
		case 4:
			catname = $("#path_level0").val() + '/' + $("#path_level1").val() + '/'  + $("#path_level2").val() + '/' + catname;
			break;
	}
	//console.log("catid="+catid+"path="+catname);
	makeRequest('action=company&job=forrank&moduleid=4&catid='+catid+'&catname='+catname, AJPath, '_getCRank');

}
function _getCRank() {
	$("#ranking_list").empty();

	var newData = false;
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		if (xmlHttp.responseText) {
			newData = true;
		}
	}
	if (!newData) {
		$("#ranking_list").append(Dd('ranking_list_0').innerHTML);
	} else {
		$("#ranking_list").append(xmlHttp.responseText);
	}

	closeCatMenu();
}

function detectZoom() {
	var ratio = 0,
		screen = window.screen,
		ua = navigator.userAgent.toLowerCase();

	if (window.devicePixelRatio !== undefined) {
		ratio = window.devicePixelRatio;
	}
	else if (~ua.indexOf('msie')) {
		if (screen.deviceXDPI && screen.logicalXDPI) {
			ratio = screen.deviceXDPI / screen.logicalXDPI;
		}
	}
	else if (window.outerWidth !== undefined && window.innerWidth !== undefined) {
		ratio = window.outerWidth / window.innerWidth;
	}

	if (ratio){
		ratio = Math.round(ratio * 100);
	}

	return ratio;
}

$(document).ready(
	function(){
		!function(){
			aboutSection=$(".about");
			aboutSection.css({display:""});
			var wh = $(window).height();
			// 第一页的min-height为868px
			if (wh > 868 && detectZoom() == 100) {
				$(".container.search").css({top: 122+(wh-868)/3});
				$(".container.main").css({top: 198+(wh-868)/3});
			}
			aboutSection.css({height: $(window).height()});

			$(window).resize(function(){
				// aboutSection.css({height:$(window).height()})
				if (document.body.clientWidth < document.body.scrollWidth) {
					document.body.scrollLeft = (document.body.scrollWidth-document.body.clientWidth)/2;
				}
			});
			new dmarquee(45, 30, 3000, 'seller')
		}()
			,$(function(){
			$(".about-content").animate({
				"margin-top": '0px',
				opacity: 1
			}, 500);
			$(".search").animate({
				left: '0px',
				opacity: 1
			}, 500);

			var e=500,t=$(".navbar");
			$(window).scroll(function(){
				var r=$(window).scrollTop();
				if(r < e){
					if (t.hasClass("navbar-sticky")) {
						t.removeClass("navbar-sticky navbar-fixed-top");
					}
					$(".navbar-inverse").css({background: '#F1F1F1'});
					$('[data-toggle="tooltip"]').tooltip('show');
				} else {
					if (!t.hasClass("navbar-sticky")) {
						t.toggleClass("navbar-sticky navbar-fixed-top");
						$(".navbar-inverse").css({background: '#000000'});
					}
				}
			});
		});
	}
);
