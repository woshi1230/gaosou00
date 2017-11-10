/*! vlogitcontrol 04-05-2014 by Marco Rosella www.marcorosella.com */
var IMGPath = DTPath+"template/default/homepage2/img/";
var vmvideos = [
  {"author":"","title":"","thumb":banner[0],"url":""}
  ,{"author":"","title":"","thumb":banner[1],"url":""}
  ,{"author":"","title":"","thumb":banner[2],"url":""}
  ,{"author":"","title":"","thumb":banner[3],"url":""}
  ,{"author":"","title":"","thumb":banner[4],"url":""}
    //荣誉资质应该为getInfoHonor.png--getInfoHonor??
    //getInfoContact=雇用联系??而不是获得经验
    //获得认证，打算拆introduce的公司档案
  //,{"author":"","title":"高手排名","thumb":IMGPath+"getInfoHonor.png","url":"getInfoHonor"}//x
  ,{"author":"","title":"江湖经历","thumb":IMGPath+"getInfoNews.png","url":"getInfoNews"}//江湖公告
  ,{"author":"","title":"出售商品","thumb":IMGPath+"b3.png","url":"getInfoBuy"}//购买装备
  ,{"author":"","title":"擅长技能","thumb":IMGPath+"getInfoJob.png","url":"getInfoJob"}//招兵买马
  ,{"author":"","title":"荣誉资质","thumb":IMGPath+"b6.png","url":"getInfoHonor"}//高手名望，把点击后的图片换对，换为荣誉资质即可
  ,{"author":"","title":"获得认证","thumb":IMGPath+"getInfoHonor.png","url":"getInfoHonor"}//x
  ,{"author":"","title":"服务保障","thumb":IMGPath+"getInfoIntroduce.png","url":"getInfoIntroduce"}//x
  ,{"author":"","title":"交易评论","thumb":IMGPath+"b1.png","url":"getInfoComment"}
  ,{"author":"","title":"雇用联系","thumb":IMGPath+"getInfoContact.png","url":"getInfoContact"}//把图片换对，换为雇用联系即可
  ,{"author":"","title":"高手任务","thumb":IMGPath+"getInfoTask.png","url":"getInfoTask"}
 ];

var CONFIG = CONFIG || {};
var animtop, vimeo, response = "", rot = 0;
var INTRO = {
  intropaper: null,
  init: function() {
    this.intropaper = new Raphael("animintro",CONFIG.currentW,CONFIG.currentH);
    $("#animintro").show();
    VL.start();
  }
};

var svg = null;
var lgs_radius = 43, cg_radius = 215;
var leftGearS = null, rightGearS = null, centerGear = null;
function drawGear() {
  // 绘制齿轮路径
  function gear(d) {
    var n = d.teeth,
      r2 = Math.abs(d.radius),
      r0 = r2 - 6,
      r1 = r2 + 6,
      r3 = d.annulus ? 201 : 20,
      da = Math.PI / n,
      a0 = -Math.PI / 2,// + (d.annulus ? Math.PI / n : 0),
      i = -1,
      path = ["M", r0 * Math.cos(a0), ",", r0 * Math.sin(a0)];
    while (++i < n) path.push(
      "A", r0, ",", r0, " 0 0,1 ", r0 * Math.cos(a0 += da), ",", r0 * Math.sin(a0),
      "L", r2 * Math.cos(a0), ",", r2 * Math.sin(a0),
      "L", r1 * Math.cos(a0 += da / 3), ",", r1 * Math.sin(a0),
      "A", r1, ",", r1, " 0 0,1 ", r1 * Math.cos(a0 += da / 3), ",", r1 * Math.sin(a0),
      "L", r2 * Math.cos(a0 += da / 3), ",", r2 * Math.sin(a0),
      "L", r0 * Math.cos(a0), ",", r0 * Math.sin(a0));
    path.push("M0,", -r3, "A", r3, ",", r3, " 0 0,0 0,", r3, "A", r3, ",", r3, " 0 0,0 0,", -r3, "Z");
    return path.join("");
  }

  svg = d3.select("#vlogitwheel svg");
  leftGearS = svg.append("g")
    .datum({radius: Infinity});
  leftGearS.append("g")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate(587,649)")
    .datum({teeth: 12, radius: lgs_radius})
    .append("path")
    .attr("d", gear);

  rightGearS = svg.append("g")
    .datum({radius: Infinity});
  rightGearS.append("g")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate(1013,649)")
    .datum({teeth: 12, radius: lgs_radius})
    .append("path")
    .attr("id", "right_gear")
    .attr("d", gear);

  centerGear = svg.append("g")
    .datum({radius: Infinity});
  centerGear.append("g")
    .style("fill-opacity", "0")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate(800,500)")
    .datum({teeth: 60, radius: cg_radius, annulus: 1})
    .append("path")
    .attr("d", gear);
};

Raphael.fn.vlogitWheel = function(aaa, b, c) {
  var transformAll = function () {
    function forever() {
      var c = [];
      var d = 360 / 5;
      c = VL.urldbAll[2];
      for (var e = 0; e < c.length; e++) {
        c[e].transform("r" + (angle + d * e) + ",800,500");
      }

      var d = 360 / 10; //22.5;
      var align = 360/20;
      c = VL.urldbAll[1];
      for (var e = 0; e < c.length; e++) {
        c[e].transform("r" + ((angle + d * e) - align) + ",800,500");
      }
    }
    var transform = function (d) {
      return "rotate(" + angle + ")";
    };
    var leftGearSTF = function (d) {
      return "rotate(" + -angle * 5 + ")";
    };
    if (centerGear) {
      centerGear.selectAll("path").attr("transform", transform);
    }
    if (leftGearS) {
      leftGearS.selectAll("path").attr("transform", leftGearSTF);
      rightGearS.selectAll("path").attr("transform", leftGearSTF);
    }
    forever();
  };

  var angleOpertor = function () {
    $("#ct_rotate").click(function(){
      rotateOpertor(!userRotate);
      if ($("#ct_rotate").hasClass("ct_rotate_0")) {
        $("#ct_rotate").removeClass("ct_rotate_0");
        $("#ct_rotate").addClass("ct_rotate_1");
      } else {
        $("#ct_rotate").removeClass("ct_rotate_1");
        $("#ct_rotate").addClass("ct_rotate_0");
      }
    });
    $("#ct_rotate").css({display: ""});

    var angleGear = 0;
    var transformGear = function () {
      var centerGearTF = function (d) {
        return "rotate(" + -angleGear + ")";
      };
      var leftGearSTF = function (d) {
        return "rotate(" + angleGear * 5 + ")";
      };
      if (leftGearS) {
        leftGearS.selectAll("path").attr("transform", leftGearSTF);
        rightGearS.selectAll("path").attr("transform", leftGearSTF);
        centerGear.selectAll("path").attr("transform", centerGearTF);
      }
    };

    function rotateOpertor(isRotate) {
      userRotate = isRotate;
    }

    var colors = [
      '26e000', '2fe300', '37e700', '45ea00', '51ef00',
      '61f800', '6bfb00', '77ff02', '80ff05', '8cff09',
      '93ff0b', '9eff09', 'a9ff07', 'c2ff03', 'd7ff07',
      'f2ff0a', 'fff30a', 'ffdc09', 'ffce0a', 'ffc30a',
      'ffb509', 'ffa808', 'ff9908', 'ff8607', 'ff7005',
      'ff5f04', 'ff4f03', 'f83a00', 'ee2b00', 'e52000'
    ];

    var rad2deg = 180 / Math.PI;
    var deg = 0;
    var bars = $('#bars');

    for (var i = 0; i < colors.length; i++) {

      deg = i * 12;

      // Create the colorbars
      $('<div class="colorBar">').css({
        backgroundColor: '#' + colors[i],
        transform: 'rotate(' + deg + 'deg)',
        top: -Math.sin(deg / rad2deg) * 30 + 53,
        left: Math.cos((180 - deg) / rad2deg) * 30 + 50,
      }).appendTo(bars);
    }

    var colorBars = bars.find('.colorBar');
    var numBars = 0, lastNum = -1;
    $('#control').knobKnob({
      snap: 10,
      value: 180,
      turn: function (ratio) {
        numBars = Math.round(colorBars.length * ratio);

        // Update the dom only when the number of active bars
        // changes, instead of on every move

        if (numBars == lastNum) {
          return false;
        }
        lastNum = numBars;
        //$('#ct_angle').val((lastNum-15)*12);
        angle = (-1) * (lastNum - 15) * 12;
        preAngle = angle;
        transformAll();

        angleGear = angle + lastNum;
        transformGear();

        colorBars.removeClass('active').slice(0, numBars).addClass('active');
      }
    });

    var preRotate = true;
    $('#control').mouseleave(function(e){
      $(".colorBar").css({display: "none"});
      $(".knob .top").css({display: "none"});
      rotateOpertor(preRotate);
    });
    $(".colorBar").css({display: "none"});
    $(".knob .top").css({display: "none"});
    $(".knob .base").html('调整');

    $('#control').mouseenter(function(e){
      preRotate = userRotate;
      rotateOpertor(false);
      $(".colorBar").css({display: "", width: "14px"});
      $(".knob .top").css({display: ""});
    });
  };

  function d() {
    if (t == loadingTotal) {
      g(c, q);
      VL.urldbAll.push(q);
      if (2 == c) {
        imgAll = q;
        m.vlogitWheel(340, VL.sourceArr.slice(5, 15), 1)
      } else if (1 == c) {
        imgAll = imgAll.concat(q);
        m.vlogitWheel(240, VL.sourceArr.slice(0, 5), 0);
      } else {
        if (0 == c) {
          imgAll = imgAll.concat(q);
          i();
        }
      }
    } else {
      setTimeout(d, 50);
    }
  }

  function e() {
    var c = m.image(this.src, 720, v, 160, 120).attr({
      opacity: 0
    }).click(function() {
        l(this);
      }
    );
    c.node.id = this.id;
    q.push(c);
    t++;
  }

  function g(a, b) {
    //if (b.length) {
    //  var x0 = 800.00;
    //  var y0 = 500.00;
    //  var r1 = 120.00;
    //  var r2 = 200.00;
    //  var x1 = 800.00;
    //  var y1 = y0 - r1;
    //  var y2 = y0 - r2;
    //  var count = b.length * 2;
    //  var cosa = Math.cos(2*Math.PI/count);
    //  var sina = Math.sin(2*Math.PI/count);
    //  if (b.length === 5) {
    //    var x=x0+(x1-x0)*cosa-(y1-y0)*sina, y=y0+(x1-x0)*sina+(y1-y0)*cosa;
    //    var d0 = "M," + x0 + "," + y0 + ",L," + x + "," + y + ",A," + r1 + "," + r1 + ",0,0,0," + (x0-(x-x0)) +"," + y + ",z";
    //  } else if (b.length === 10) {
    //    var x=x0+(x1-x0)*cosa-(y2-y0)*sina, y=y0+(x1-x0)*sina+(y2-y0)*cosa;
    //    var d1 = "M," + x0 + "," + y0 + ",L," + x + "," + y + ",A," + r2 + "," + r2 + ",0,0,0," + (x0-(x-x0)) +"," + y + ",z";
    //  }
    //  console.log("d0="+d0);
    //  console.log("d1="+d1);
    //}

    slicepath = [
      m.path("M,800,500,L,870.5342302750968,402.91796067500627,A,120,120,0,0,0,729.4657697249032,402.91796067500627,z")
        .attr({stroke: "none"})
      , m.path("M,800,500,L,861.3033988749895,309.78869674096927,A,200,200,0,0,0,738.6966011250105,309.78869674096927,z")
        .attr({stroke: "none"})
    ];
    var c = document.createElementNS(r, "clipPath");
    c.setAttribute("id", "clip_ring" + a);
    s.appendChild(c);
    for (var d = 0; d < b.length; d++) {
      var e = angleplus * d;
      b[d].rotate(e, 80, 50);
      b[d].node.setAttribute("clip-path", "url(#clip_ring" + a + ")");
      b[d].node.style.cursor = "pointer";
      //b[d].attr({
      //  opacity: 0
      //});
      //b[d].hover(function() {}
      //  , function() {}
      //);
      c.appendChild(slicepath[a].node);
      h(b[d], angleplus, d);
      o += angleplus;
      n.push(b[d]);
    }
  }

  function h(a, b, d) {
    a.attr({
      transform: "r" + b * d + ",800,500t0,140"
    })
  }

  function i() {
    function a() {
      if (b == c.length) {
        j();
      } else {
        c[b].attr({
          opacity: 1
        }).animate({
            transform: "r" + (d * b) + ",800,500t0,0"
          }, 100, "<>", function () {
            b++;
            a();
          }
        )
      }
    }
    var b = 0;
    var c = VL.urldbAll[2];
    var d = 360 / 5;
    a();
    $("#logo").addClass("active");
  }

  function j() {
    var b = 360 / 10; //22.5;
    var align = 360/20;
    var c = 0;
    for (var a = VL.urldbAll[1]; c < a.length; c++) {
      c == a.length - 1 ?
        a[c].attr({
        opacity: 1
      }).animate({
          transform: "r" + (b * c - align) + ",800,500t0,0"
        }, 1e3, "<>", function () {
          isRotate = true;
          angleOpertor();
        }
      ) :
        a[c].attr({
          opacity: 1
        }).animate({
            transform: "r" + (b * c - align) + ",800,500t0,0"
          }, 1e3, "<>", function () {}
        )
    }
  }

  var cSeleImg = '';
  function l(obj) {
    console.log('点击: '+obj.node.id);
    if (cSeleImg !== obj.node.id) {
      if (cSeleImg) {
        $("#"+cSeleImg).attr("href", IMGPath + cSeleImg + ".png");
      }
      cSeleImg = obj.node.id;
      $("#"+cSeleImg).attr("href", IMGPath + cSeleImg + "2.png");
    }
    menuFuncs[obj.node.id]();
  }

  // 驱动svg对象旋转功能
  var isRotate = false;
  var userRotate = true;
  var step = 0, angle = 0, preAngle = 0;
  d3.timer(function() {
    if (!isRotate || !userRotate || step++ < 3) {
      return false;
    } else {
      step = 0;
    }
    angle = preAngle + 0.2;
    preAngle = angle;
    transformAll();
  });

  var m = this
    , n = this.set()
    , o = 0
    , p = 0
    , q = []
    , r = "http://www.w3.org/2000/svg"
    , s = (document.getElementsByTagName("defs")[0]
    , document.getElementsByTagName("svg")[0])
    , t = 0;

  loadingTotal = b.length;
  for (var u = 0; u < b.length; u++) {
    p = null;
    angleplus = 360 / b.length;
    var v = 360 - 80 * c;
    var w = new Image;
    w.onload = e;
    //w.onerror = f;
    w.src = b[u].thumb;
    w.id = b[u].url;
    w.title = b[u].title;
    w.author = b[u].author;
  }
  return d(), n
}
;

VL = VL || {};
VL.window = window;
var VL = {
  paper: null ,
  sourceArr: [],
  imgAll: [],
  urldbAll: [],
  init: function() {
    INTRO.init();
  },
  start: function() {
    this.paper = new Raphael("vlogitwheel",1070,800);
    drawGear();
    this.sourceArr = vmvideos;
    this.paper.vlogitWheel(440, VL.sourceArr.slice(32, 51), 2);
  }
};

$(function() {
  VL.init();
});

// 设置点击轮盘执行的函数对象数组
var menuFuncs = {};
menuFuncs['getInfoIntroduce'] = function () {
  makeRequest('action=introduce&template=homepage2&moduleid=6&userid=2&username='+username, 'introduce', '_getInfo');//news
};
menuFuncs['getInfoTask'] = function () {
  makeRequest('action=task&template=homepage2&moduleid=42&username='+username, 'task', '_getInfo');
};
menuFuncs['getInfoBuy'] = function () {
  makeRequest('action=buy&template=homepage2&moduleid=42&username='+username, 'buy', '_getInfo');
};
menuFuncs['getInfoHonor'] = function () {
  makeRequest('action=honor&template=homepage2&moduleid=42&username='+username, 'honor', '_getInfo');
};
menuFuncs['getInfoJob'] = function () {
  makeRequest('action=job&template=homepage2&moduleid=42&username='+username, 'job', '_getInfo');
};
menuFuncs['getInfoContact'] = function () {
  makeRequest('action=contact&template=homepage2&moduleid=42&username='+username, 'contact', '_getInfo');
};
menuFuncs['getInfoNews'] = function () {
  makeRequest('action=news&template=homepage2&moduleid=42&username='+username, 'news', '_getInfo');
};
menuFuncs['getInfoComment'] = function () {
  makeRequest('action=comment&template=homepage2&moduleid=6&userid=2&username='+username, 'comment', '_getInfo');//news
};

function _getInfo() {
  if(xmlHttp.readyState==4 && xmlHttp.status==200) {
    if (xmlHttp.responseText) {
      $("#seller .mthumb")[0].innerHTML = xmlHttp.responseText;
    }
  }
}
