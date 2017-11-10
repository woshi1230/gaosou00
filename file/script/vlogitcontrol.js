/*! vlogitcontrol 04-05-2014 by Marco Rosella www.marcorosella.com */
var IMGPath = DTPath+"template/default/homepage2/img/";
var vmvideos = [
  {"order":14,"title":"高手排名","thumb":IMGPath+"getInfoIntroduce.png","url":"getInfoIntroduce"}
  ,{"order":15,"title":"江湖经历","thumb":IMGPath+"getInfoNews.png","url":"getInfoNews"}
  ,{"order":16,"title":"拥有绝招","thumb":IMGPath+"getInfoJob.png","url":"getInfoJob"}
  ,{"order":17,"title":"出售商品","thumb":IMGPath+"getInfoMall.png","url":"getInfoMall"}//热卖、供应
  ,{"order":18,"title":"获得认证","thumb":IMGPath+"getInfoAuthentication.png","url":"getInfoAuthentication"}
  ,{"order":19,"title":"荣誉资质","thumb":IMGPath+"getInfoHonor.png","url":"getInfoHonor"}
  ,{"order":20,"title":"服务保障","thumb":IMGPath+"getInfoGuarantee.png","url":"getInfoGuarantee"}
  ,{"order":21,"title":"交易评价","thumb":IMGPath+"getInfoComment.png","url":"getInfoComment"}
  ,{"order":22,"title":"雇用联系","thumb":IMGPath+"getInfoContact.png","url":"getInfoContact"}
  ,{"order":23,"title":"高手任务","thumb":IMGPath+"getInfoTask.png","url":"getInfoTask"}
  ,{"order":2,"title":title[0],"thumb":banner[0],"url":""}
  ,{"order":3,"title":title[1],"thumb":banner[1],"url":""}
  ,{"order":4,"title":title[2],"thumb":banner[2],"url":""}
  ,{"order":5,"title":title[3],"thumb":banner[3],"url":""}
  ,{"order":6,"title":title[4],"thumb":banner[4],"url":""}
  ,{"order":7,"title":title[5],"thumb":banner[5],"url":""}
  ,{"order":8,"title":title[6],"thumb":banner[6],"url":""}
  ,{"order":9,"title":title[7],"thumb":banner[7],"url":""}
  ,{"order":10,"title":title[8],"thumb":banner[8],"url":""}
  ,{"order":11,"title":title[9],"thumb":banner[9],"url":""}
  ];
//console.log(title);
var CONFIG = CONFIG || {};
var animtop, vimeo, response = "", rot = 0;
var INTRO = {
  intropaper: null,
  init: function() {
    this.intropaper = new Raphael("animintro",1,1);
    $("#animintro").show();
    VL.start();
  }
};

var svg = null;
var origin_x = 263, origin_y = 270;
var lgs_radius = 43, cg_radius = 215;
var leftGearT = null, rightGearT = null, leftGearB = null, rightGearB = null, centerGear = null;
//// 这是测试角度指针
//var angleLine = null;
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
  leftGearT = svg.append("g")
    .datum({radius: Infinity});
  leftGearT.append("g")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate("+(origin_x-211.5)+","+(origin_y-148.5)+")")
    .datum({teeth: 12, radius: lgs_radius})
    .append("path")
    .attr("d", gear);

  rightGearT = svg.append("g")
    .datum({radius: Infinity});
  rightGearT.append("g")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate("+(origin_x+212.5)+","+(origin_y-148.5)+")")
    .datum({teeth: 12, radius: lgs_radius})
    .append("path")
    .attr("id", "right_gear")
    .attr("d", gear);

  leftGearB = svg.append("g")
    .datum({radius: Infinity});
  leftGearB.append("g")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate("+(origin_x-211.5)+","+(origin_y+148.5)+")")
    .datum({teeth: 12, radius: lgs_radius})
    .append("path")
    .attr("d", gear);

  rightGearB = svg.append("g")
    .datum({radius: Infinity});
  rightGearB.append("g")
    .style("stroke", "gray")
    .style("fill", "#fff")
    .attr("transform", "translate("+(origin_x+212.5)+","+(origin_y+148.5)+")")
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
    .attr("transform", "translate(" + origin_x + "," + origin_y + ")")
    .datum({teeth: 60, radius: cg_radius, annulus: 1})
    .append("path")
    .attr("d", gear);

  // 在svg中插入 circle, 来作为各扇形之间的分界线
  svg.append('circle').attr({
    cx: origin_x,
    cy: origin_y,
    r: 199
  }).style({
    fill: 'grey'
  });

  //// 这是测试角度指针
  //angleLine = svg.append("g");
  //angleLine.append('path').attr("d", "M" + origin_x + "," + origin_y + "," + origin_x + ",0")
  //  .style("stroke", "red")
  //  .style("stroke-width", "1")
  //  .attr("transform", "rotate(" + (360/20) + " " + origin_x + " " + origin_y + ")")
}

var run_state = {ltRunid:'', rtRunid:'', lbRunid:'', rbRunid:''};
Raphael.fn.vlogitWheel = function(aaa, b, c) {
  var transformAll = function (reContent) {
    var transform = function (d) {
      return "rotate(" + angle + ")";
    };
    var leftGearSTF = function (d) {
      return "rotate(" + -angle * 5 + ")";
    };
    if (centerGear) {
      centerGear.selectAll("path").attr("transform", transform);
    }
    if (leftGearB) {
      leftGearT.selectAll("path").attr("transform", leftGearSTF);
      leftGearB.selectAll("path").attr("transform", leftGearSTF);
      rightGearT.selectAll("path").attr("transform", leftGearSTF);
      rightGearB.selectAll("path").attr("transform", leftGearSTF);
    }
    //// 这是测试角度指针
    //var transform2 = function (d) {
    //  return "rotate(" + (angle+360/20) + " " + origin_x + " " + origin_y + ")";
    //};
    //if (angleLine) {
    //  angleLine.selectAll("path").attr("transform", transform2);
    //}

    var lt_angle = 266.7;
    var rt_angle = 59;
    var lb_angle = 236.7;
    var rb_angle = 85;
    var c = [];
    var d = 360 / 10;
    c = VL.urldbAll[2];
    for (var e = 0; e < c.length; e++) {
      if (reContent) {
        var deg = c[e]._.deg % 360;

        if ((deg >= lt_angle) && (deg < lt_angle + d)) {
          if (run_state.ltRunid != c[e].node.id) {
            run_state.ltRunid = c[e].node.id;
            //console.log(c[e].node.title);
            menuFuncs[c[e].node.id]('lt');
          }
        }

        if ((deg >= rt_angle) && (deg < rt_angle + d)) {
          if (run_state.rtRunid != c[e].node.id) {
            run_state.rtRunid = c[e].node.id;
            //console.log(c[e].node.title);
            menuFuncs[c[e].node.id]('rt');
          }
        }

        if ((deg >= lb_angle) && (deg < lb_angle + d)) {
          if (run_state.lbRunid != c[e].node.id) {
            run_state.lbRunid = c[e].node.id;
            //console.log(c[e].node.title);
            menuFuncs[c[e].node.id]('lb');
          }
        }

        if ((deg >= rb_angle) && (deg < rb_angle + d)) {
          if (run_state.rbRunid != c[e].node.id) {
            run_state.rbRunid = c[e].node.id;
            //console.log(c[e].node.title);
            menuFuncs[c[e].node.id]('rb');
          }
        }
      }
      c[e].transform("r" + (angle + d * e) + "," + origin_x + "," + origin_y + "");
    }

    var d = 360 / 10; //22.5;
    //var align = 360/20;
    c = VL.urldbAll[1];
    for (var e = 0; e < c.length; e++) {
      c[e].transform("r" + (angle + d * e) + "," + origin_x + "," + origin_y + "");
    }
  };

  var angleOpertor = function () {
    $("#ct_rotate").click(function(){
      isRotate = !isRotate;
      rotateOpertor(isRotate);
      if ($("#ct_rotate").hasClass("ct_rotate_0")) {
        $("#ct_rotate").removeClass("ct_rotate_0");
        $("#ct_rotate").addClass("ct_rotate_1");
        $("#ct_rotate").html("停止");
      } else {
        $("#ct_rotate").removeClass("ct_rotate_1");
        $("#ct_rotate").addClass("ct_rotate_0");
        $("#ct_rotate").html("旋转");
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
      if (leftGearB) {
        leftGearT.selectAll("path").attr("transform", leftGearSTF);
        leftGearB.selectAll("path").attr("transform", leftGearSTF);
        rightGearT.selectAll("path").attr("transform", leftGearSTF);
        rightGearB.selectAll("path").attr("transform", leftGearSTF);
        centerGear.selectAll("path").attr("transform", centerGearTF);
      }
    };

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
        top: -Math.sin(deg / rad2deg) * 28 + 52,
        left: Math.cos((180 - deg) / rad2deg) * 28 + 49,
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
        transformAll(false);

        angleGear = angle + lastNum;
        transformGear();

        colorBars.removeClass('active').slice(0, numBars).addClass('active');
      }
    });

    $('#control').mouseleave(function(e){
      $(".colorBar").css({display: "none"});
      $(".knob .top").css({display: "none"});
      rotateOpertor(preRotate);
    });
    $(".colorBar").css({display: "none"});
    $(".knob .top").css({display: "none"});
    //    搜狗浏览器样式兼容处理

    var Browser=Browser || (function(window){
        var document = window.document,
          navigator = window.navigator,
          agent = navigator.userAgent.toLowerCase(),
        //IE8+支持.返回浏览器渲染当前文档所用的模式
        //IE6,IE7:undefined.IE8:8(兼容模式返回7).IE9:9(兼容模式返回7||8)
        //IE10:10(兼容模式7||8||9)
          IEMode = document.documentMode,
        //chorme
          chrome = window.chrome || false ,
          System = {
            //user-agent
            agent : agent,
            //是否为IE
            isIE : /msie/.test(agent),
            //Gecko内核
            isGecko: agent.indexOf( "gecko" )> 0 && agent.indexOf( "like gecko" )< 0 ,
            //webkit内核
            isWebkit: agent.indexOf( "webkit" )> 0 ,
            //是否为标准模式
            isStrict: document.compatMode === "CSS1Compat" ,
            //是否支持subtitle
            supportSubTitle:function(){
              return "track" in document.createElement( "track" );
            },
            //是否支持scoped
            supportScope:function(){
              return "scoped" in document.createElement( "style" );
            },
            //获取IE的版本号
            ieVersion:function(){
              try {
                return agent.match(/msie ([\d.]+)/)[ 1 ] || 0 ;
              } catch (e) {
                console.log( "error" );
                return IEMode;
              }
            },
            //Opera版本号
            operaVersion:function(){
              try {
                if (window.opera) {
                  return agent.match(/opera.([\d.]+)/)[ 1 ];
                } else if (agent.indexOf( "opr" ) > 0 ) {
                  return agent.match(/opr\/([\d.]+)/)[ 1 ];
                }
              } catch (e) {
                console.log( "error" );
                return 0 ;
              }
            },
            //描述:version过滤.如31.0.252.152 只保留31.0
            versionFilter:function(){
              if (arguments.length === 1 && typeof arguments[ 0 ] === "string" ) {
                var version = arguments[ 0 ];
                start = version.indexOf( "." );
                if (start> 0 ){
                  end = version.indexOf( "." ,start+ 1 );
                  if (end !== - 1 ) {
                    return version.substr( 0 ,end);
                  }
                }
                return version;
              } else if (arguments.length === 1 ) {
                return arguments[ 0 ];
              }
              return 0 ;
            }
          };

        try {
          //浏览器类型(IE、Opera、Chrome、Safari、Firefox)
          System.type = System.isIE? "IE" :
            window.opera || (agent.indexOf( "opr" ) > 0 )? "Opera" :
              (agent.indexOf( "chrome" )> 0 )? "Chrome" :
                //safari也提供了专门的判定方式
                window.openDatabase? "Safari" :
                  (agent.indexOf( "firefox" )> 0 )? "Firefox" :
                    'unknow' ;

          //版本号
          System.version = (System.type === "IE" )?System.ieVersion():
            (System.type === "Firefox" )?agent.match(/firefox\/([\d.]+)/)[ 1 ]:
              (System.type === "Chrome" )?agent.match(/chrome\/([\d.]+)/)[ 1 ]:
                (System.type === "Opera" )?System.operaVersion():
                  (System.type === "Safari" )?agent.match(/version\/([\d.]+)/)[ 1 ]:
                    "0" ;

          //浏览器外壳
          System.shell=function(){
            //遨游浏览器
            if (agent.indexOf( "maxthon" ) > 0 ) {
              System.version = agent.match(/maxthon\/([\d.]+)/)[ 1 ] || System.version ;
              return "傲游浏览器" ;
            }
            //QQ浏览器
            if (agent.indexOf( "qqbrowser" ) > 0 ) {
              System.version = agent.match(/qqbrowser\/([\d.]+)/)[ 1 ] || System.version ;
              return "QQ浏览器" ;
            }

            //搜狗浏览器
            if ( agent.indexOf( "se 2.x" )> 0 ) {
              return '搜狗浏览器' ;
            }

            //Chrome:也可以使用window.chrome && window.chrome.webstore判断
            if (chrome && System.type !== "Opera" ) {
              var external = window.external,
                clientInfo = window.clientInformation,
              //客户端语言:zh-cn,zh.360下面会返回undefined
                clientLanguage = clientInfo.languages;

              //猎豹浏览器:或者agent.indexOf("lbbrowser")>0
              if ( external && 'LiebaoGetVersion' in external) {
                return '猎豹浏览器' ;
              }
              //百度浏览器
              if (agent.indexOf( "bidubrowser" )> 0 ) {
                System.version = agent.match(/bidubrowser\/([\d.]+)/)[ 1 ] ||
                  agent.match(/chrome\/([\d.]+)/)[ 1 ];
                return "百度浏览器" ;
              }
              //360极速浏览器和360安全浏览器
              if ( System.supportSubTitle() && typeof clientLanguage === "undefined" ) {
                //object.key()返回一个数组.包含可枚举属性和方法名称
                var storeKeyLen = Object.keys(chrome.webstore).length,
                  v8Locale = "v8Locale" in window;
                return storeKeyLen > 1 ? '360极速浏览器' : '360安全浏览器' ;
              }
              return "Chrome" ;
            }
            return System.type;
          };

          //浏览器名称(如果是壳浏览器,则返回壳名称)
          System.name = System.shell();
          //对版本号进行过滤过处理
          System.version = System.versionFilter(System.version);

        } catch (e) {
          console.log( "error" );
        }
        return {
          client:System
        };

      })(window);
    if(Browser.client.name == '搜狗浏览器'){
      $(".knob .base").css({"fill": "grey", "font-size": "14px", "font-weight": "bold","margin-top":"-5px"});
    }else{
      $(".knob .base").css({"fill": "grey", "font-size": "14px", "font-weight": "bold"});
    }
    $(".knob .base").html('调整');


    $('#control').mouseenter(function(e){
      preRotate = userRotate;
      rotateOpertor(false);
      $(".colorBar").css({display: "", width: "14px"});
      $(".knob .top").css({display: ""});
    });

    // 在svg中插入 circle, 来作为上下2层的分界线
    svg.append('circle').attr({
      cx: origin_x,
      cy: origin_y,
      r: 120
    }).style({
      fill: 'none',
      stroke: 'grey',
      'stroke-width': 1
    });

    // 绘制中心图片
    d3.select("#clip_ring2")
      .append('circle')
      .attr({
        cx: origin_x,
        cy: origin_y,
        r: 125/2+1
      })
      .style({fill: 'none'});
    svg.append("image")
      .attr("x", origin_x-125/2)
      .attr("y", origin_y-125/2)
      .attr("width", 125)
      .attr("height", 125)
      .attr("xlink:href", function(d) {
          return DTPath+"template/default/homepage2/img/taichi.jpg";
      })
      .attr("clip-path", "url(#clip_ring2)")

  };

  function d() {
    if (t == loadingTotal) {
      q.forEach(function(item){item.id=item.node.order;});
      q = q.sort(function(a, b){return a.id - b.id;});
      g(c, q);
      VL.urldbAll.push(q);
      if (2 == c) {
        imgAll = q;
        m.vlogitWheel(340, VL.sourceArr.slice(10, 20), 1)
      } else if (1 == c) {
        imgAll = imgAll.concat(q);
        m.vlogitWheel(240, VL.sourceArr.slice(0, 10), 0);
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
    var c = m.image(this.src, imgX, imgY, imgW, imgH).attr({
      opacity: 0
    }).click(function() {
        l(this);
      }
    );
    c.node.id = this.id;
    c.node.title = this.title;
    c.node.order = this.order;
    q.push(c);
    t++;
  }

  function e2() {
    var c = m.image(user_def_img, imgX, imgY, imgW, imgH).attr({
      opacity: 0
    }).click(function() {
        l(this);
      }
    );
    c.node.id = this.id;
    c.node.title = this.title;
    c.node.order = this.order;
    q.push(c);
    t++;
  }

  function g(a, b) {
    //if (b.length) {
    //  var x0 = origin_x;
    //  var y0 = origin_y;
    //  var r1 = 120.00;
    //  var r2 = 200.00;
    //  var x1 = origin_x;
    //  var y1 = y0 - r1;
    //  var y2 = y0 - r2;
    //  var count = b.length * 2;
    //  var cosa = Math.cos(2*Math.PI/count);
    //  var sina = Math.sin(2*Math.PI/count);
    //  //if (b.length === 5) {
    //    var x=x0+(x1-x0)*cosa-(y1-y0)*sina, y=y0+(x1-x0)*sina+(y1-y0)*cosa;
    //    var d0 = "M," + x0 + "," + y0 + ",L," + (x-0.5) + "," + y + ",A," + r1 + "," + r1 + ",0,0,0," + (x0-(x-x0)+0.5) +"," + y + ",z";
    //  //} else if (b.length === 10) {
    //    var x=x0+(x1-x0)*cosa-(y2-y0)*sina, y=y0+(x1-x0)*sina+(y2-y0)*cosa;
    //    var d1 = "M," + x0 + "," + y0 + ",L," + (x-0.5) + "," + y + ",A," + r2 + "," + r2 + ",0,0,0," + (x0-(x-x0)+0.5) +"," + y + ",z";
    //  //}
    //  console.log("d0="+d0);
    //  console.log("d1="+d1);
    //}

    slicepath = [
      m.path("M,263,270,L,299.5820393249937,155.87321804458156,A,120,120,0,0,0,226.41796067500633,155.87321804458156,z")
        .attr({stroke: "none"})
      , m.path("M,263,270,L,324.30339887498945,79.7886967409693,A,200,200,0,0,0,201.69660112501055,79.7886967409693,z")
        .attr({stroke: "none"})
    ];
    var c = document.createElementNS(r, "clipPath");
    c.setAttribute("id", "clip_ring" + a);
    s.appendChild(c);
    for (var d = 0; d < b.length; d++) {
      var e = angleplus * d;
      b[d].rotate(e, 80, 50);
      b[d].node.setAttribute("preserveAspectRatio", "xMidYMid slice");
      b[d].node.setAttribute("clip-path", "url(#clip_ring" + a + ")");
      b[d].node.style.cursor = "pointer";
      //b[d].attr({
      //  opacity: 0
      //});
      b[d].hover(function() {
        $("#menu_name").text(this.node.title);
        rotateOpertor(false);
      }
        , function() {rotateOpertor(true);}
      );
      c.appendChild(slicepath[a].node);
      h(b[d], angleplus, d);
      o += angleplus;
      n.push(b[d]);
    }
  }

  function h(a, b, d) {
    a.attr({
      transform: "r" + b * d + "," + origin_x + "," + origin_y + "t0,140"
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
            transform: "r" + (d * b) + "," + origin_x + "," + origin_y + "t0,0"
          }, 100, "<>", function () {
            b++;
            a();
          }
        )
      }
    }
    var b = 0;
    var c = VL.urldbAll[2];
    var d = 360 / 10;
    a();
    $("#logo").addClass("active");
  }

  function j() {
    var b = 360 / 10; //22.5;
    //var align = 360/20;
    var c = 0;
    for (var a = VL.urldbAll[1]; c < a.length; c++) {
      c == a.length - 1 ?
        a[c].attr({
        opacity: 1
      }).animate({
          transform: "r" + (b * c) + "," + origin_x + "," + origin_y + "t0,0"
        }, 1e3, "<>", function () {
          isRotate = true;
          angleOpertor();
        }
      ) :
        a[c].attr({
          opacity: 1
        }).animate({
            transform: "r" + (b * c) + "," + origin_x + "," + origin_y + "t0,0"
          }, 1e3, "<>", function () {}
        )
    }
  }

  var cSeleImg = '';
  function l(obj) {
    //console.log('点击: '+obj.node.id);
    function i() {
      function a() {
        for (var b = 0; b < c.length; b++) {
          c[b].attr({
            opacity: 1
          }).animate({
              transform: "r" + ((c[b].node.order-obj.node.order) * 360/10) + "," + origin_x + "," + origin_y + "t0,0"
            }, 500, "<>", function () {}
          )
        }
      }
      var c = VL.urldbAll[2];
      a();
    }

    if (obj.node.id) {
      i();
      angle = 360 - (obj.node.order - 14) * 360/10;
      preAngle = angle;
      transformAll(false);

      if (cSeleImg !== obj.node.id) {
        if (cSeleImg) {
          $("#" + cSeleImg).attr("href", IMGPath + cSeleImg + ".png");
        }
        cSeleImg = obj.node.id;
        $("#" + cSeleImg).attr("href", IMGPath + cSeleImg + "2.png");
      }
      menuFuncs[obj.node.id]('lt');
    } else {
      //var url = 'photo';
      //var modal = $.scojs_modal({
      //  remote : url,
      //  title : '高手相册'
      //});
      //modal.show();
      window.open('photo');
    }
  }

  // 驱动svg对象旋转功能
  var isRotate = false;
  var step = 0, angle = 0, preAngle = 0;
  d3.timer(function() {
    if (!isRotate || !userRotate || step++ < 3) {
      return false;
    } else {
      step = 0;
    }
    if (angle>=360) preAngle = 0;
    angle = preAngle + 0.2;
    preAngle = angle;
    transformAll(true);
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
    if (c == 1) {
      var imgX = origin_x-80;
      var imgY = 60;
      var imgW = 160;
      var imgH = 120;
    } else {
      var imgX = origin_x-45;
      var imgY = 145;
      var imgW = 90;
      var imgH = 72;
    }
    var w = new Image;
    w.onload = e;
    w.onerror = e2;
    w.src = b[u].thumb;
    w.id = b[u].url;
    w.title = b[u].title;
    w.order = b[u].order;
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
    this.paper = new Raphael("vlogitwheel",525,560);
    drawGear();
    this.sourceArr = vmvideos;
    this.paper.vlogitWheel(440, VL.sourceArr.slice(32, 51), 2);
  }
};

$(function() {
  VL.init();
});

var preRotate = true;
var userRotate = true;
function rotateOpertor(isRotate) {
  userRotate = isRotate;
}
function content_enter() {
  preRotate = userRotate;
  rotateOpertor(false);
}
function content_leave() {
  rotateOpertor(preRotate);
}

// 设置点击轮盘执行的函数对象数组。
var menuFuncs = {};
menuFuncs['getInfoIntroduce'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Introduce.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<a href = \""+DTPath+"main.html#pos\" target=\"_blank\"><span>高手排名</span></a>";
  makeRequest('homepage='+username + '&file=introduce&template=homepage2&moduleid=42', 'introduce', '_getInfo_' + pos);

};
menuFuncs['getInfoIntroduces'] = function (pos) {
  makeRequest('homepage='+username + '&file=introduces&template=homepage2&moduleid=42', 'introduces', '_getInfo_' + pos);
};
menuFuncs['getAllRating'] = function (pos) {
  makeRequest('homepage='+username + '&file=allrating&template=homepage2&moduleid=42', 'allrating', '_getInfo_' + pos);
};

menuFuncs['getInfoComments'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Introduce.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<a href = \""+DTPath+"main.html#pos\" target=\"_blank\"><span>雇用联系</span></a>";
  makeRequest('homepage='+username + '&file=comments&template=homepage2&moduleid=42', 'comments', '_getInfo_' + pos);

};
menuFuncs['getInfoAuthentication'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Authentication.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "获得认证";
  makeRequest('homepage='+username + '&file=authentication&template=homepage2&moduleid=42', 'authentication?type=2', '_getInfo_' + pos);
};
menuFuncs['getInfoGuarantee'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Guarantee.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "服务保障";
  makeRequest('homepage='+username + '&file=guarantee&template=homepage2&moduleid=42', 'guarantee', '_getInfo_' + pos);
};
menuFuncs['getInfoComment'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Comment.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "交易评价";
  makeRequest('homepage='+username + '&file=comment&template=homepage2&moduleid=42', 'comment', '_getInfo_' + pos);
};
menuFuncs['getInfoTask'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Task.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<a href=\""+DTPath+"buy\" target=\"_blank\"><span>高手任务</span></a>";
  makeRequest('homepage='+username + '&file=task&template=homepage2&moduleid=42', 'task', '_getInfo_' + pos);
};
//menuFuncs['getInfoBuy'] = function () {
//  //Dd('header_right').style.background="url("+IMGPath+"Buy.png)";
//  $("." + pos + "_title")[0].innerHTML = "服务保障";
//  makeRequest('homepage='+username + '&file=buy&template=homepage2&moduleid=42', 'buy', '_getInfo');
//};
menuFuncs['getInfoMall'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Mall.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<a href=\""+DTPath+"mall\" target=\"_blank\"><span>出售商品</span></a>";
  makeRequest('homepage='+username + '&file=mall&template=homepage2&moduleid=42', 'mall', '_getInfo_' + pos);
};
menuFuncs['getInfoHonor'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Honor.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "荣誉资质";
  makeRequest('homepage='+username + '&file=honor&template=homepage2&moduleid=42', 'honor', '_getInfo_' + pos);
};
menuFuncs['getInfoJob'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Job.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "拥有绝招";
  makeRequest('homepage='+username + '&file=job&template=homepage2&moduleid=42', 'job', '_getInfo_' + pos);
};
menuFuncs['getInfoContact'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Contact.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<span>雇用联系</span>";
  makeRequest('homepage='+username + '&file=contact&template=homepage2&moduleid=42', 'contact', '_getInfo_' + pos);
};
menuFuncs['getInfoContacts'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"Contact.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<a href=\""+DTPath+"master\" target=\"_blank\"><span>雇用联系</span></a>";
  makeRequest('homepage='+username + '&file=contacts&template=homepage2&moduleid=42', 'contacts', '_getInfo_' + pos);
};
menuFuncs['getInfoNews'] = function (pos) {
  //Dd('header_right').style.background="url("+IMGPath+"News.png)";
  if (!pos) pos='rt';
  $("." + pos + "_title")[0].innerHTML = "<span>江湖经历</span>";
  makeRequest('homepage='+username + '&file=news&template=homepage2&moduleid=42', 'news', '_getInfo_' + pos);
};
