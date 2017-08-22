var radius = 250;

(function() {
  var margin = {top: 310, right: 330, bottom: 310, left: 330};
  var padding_top = 7, margin_left = -5, labelArcMargin = 30;
  var lg_radius = 80, lgs_radius = 50, cg_radius = 300;

  // 用10种颜色构建一个ordinal变换。
  var hue = d3.scale.category10();

  // 创建一个求平方根的定量转换。
  var luminance = d3.scale.sqrt()
    .domain([0, 1e6])
    .clamp(true)
    .range([90, 20]);

  // 绘制齿轮路径
  function gear(d) {
    var n = d.teeth,
      r2 = Math.abs(d.radius),
      r0 = r2 - 6,
      r1 = r2 + 6,
      r3 = d.annulus ? (r3 = r0, r0 = r1, r1 = r3, r2 + 20) : 20,
      da = Math.PI / n,
      a0 = -Math.PI / 2 + (d.annulus ? Math.PI / n : 0),
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

  var svg = d3.select("#d3_1").append("svg")
    .attr("width", margin.left + margin.right)
    .attr("height", margin.top + margin.bottom)
    .attr("style", "padding-top: " + padding_top + "px;")
    .append("g")
    .attr("transform", "translate(" + margin.left + ",300)");

  var partition = d3.layout.partition()
    .sort(function(a, b) { return d3.ascending(a.ord, b.ord); })
    .size([2 * Math.PI, radius]);

  var arc = d3.svg.arc()
    .startAngle(function(d) { return d.x; })
    .endAngle(function(d) { return d.x + d.dx ; })
    .padAngle(.01)
    .padRadius(radius / 4 - radius / 8)
    .innerRadius(function(d) {
      return radius / 4 * d.depth - radius / 8;
    })
    .outerRadius(function(d) {
      return radius / 4 * (d.depth + 1) - radius / 8 ;
    });

  //// 包含在主扇形路径中的隐藏子扇形路径了，用于标签跟随路径，产生文字圆弧显示效果。
  //var labelArc = d3.svg.arc()
  //  .startAngle(function(d) { return d.x; })
  //  .endAngle(function(d) { return d.x + d.dx ; })
  //  .padAngle(.01)
  //  .padRadius(radius / 4 - radius / 8)
  //  .innerRadius(function(d) {
  //    return radius / 4 * d.depth - radius / 8;
  //  })
  //  .outerRadius(function(d) {
  //    return radius / 4 * (d.depth + 1) - radius / 8 - labelArcMargin;
  //  });

  var rootNode = null;
  var currRoot = null;
  var path = null;
  var image = null;
  var preKey = '';
  var levelSelect = [], levelPath = {};
  var leftGearT = null, leftGearB = null, rightGearT = null, rightGearB = null, centerGear = null;

  d3.json("file/cache/catetree.json", function(error, root) {
    if(error)
      console.log(error);
    rootNode = root;
    // Compute the initial layout on the entire tree to sum sizes.
    // Also compute the full name and fill color for each node,
    // and stash the children so they can be restored as we descend.
    partition
      .value(function(d) { return d.size; })
      .nodes(root)
      .forEach(function(d) {
        d._children = d.children;
        d.sum = d.value;
        d.key = key(d);
        d.fill = fill(d);
      });

    // Now redefine the value function to use the previously-computed sum.
    partition
      .children(function(d, depth) { return depth < 1 ? d._children : null; })
      .value(function(d) { return d.sum; });

    var center = svg.append("circle")
      .attr("r", radius / 3);

    var fristName = partition.nodes(root)[1].id;
    var treeNode = partition.nodes(root).slice(0);

    currRoot = treeNode.map(function(item){
      var obj = {};
      $.extend(obj,item);
      delete obj.children;
      return obj;
    });

    //var colorArr = ['#6BB942', '#F99C38', '#4EB7AF', '#FF7300', '#46B8E0', '#46B8E0', '#46B8E0', '#46B8E0', '#46B8E0', '#46B8E0'];
    var colorArr = ['#C4F5BD', '#F99C38', '#4EB7AF', '#FF7300', '#46B8E0', '#46B8E0', '#46B8E0', '#46B8E0', '#46B8E0', '#46B8E0'];
    for(var i=0; i<root._children.length; i++) {
      setColor(root._children[i], colorArr[i]);
    }
    //console.log(root);

    path = svg.selectAll("path")
      .data(partition.nodes(root).slice(1).filter(function(item){
        return (item.depth <= 4 || item.key.indexOf(fristName) === 0);
      }))
      .enter().append("path")
      .attr("d", arc)
      .attr("id", function(d) {
        return d.id;
      })
      .style("fill", function(d) {
        return d.fill;
      })
      .style("stroke", "gray")
      .style("stroke-width", "0.5")
      .each(function(d) { this._current = updateArc(d); })
      //.on("mouseenter",update_legend)
      //.on("mouseout",remove_legend)
      //.on("click", preZoomIn)
      //.append("path")
      //.attr("d", labelArc)
      //.attr("id", function(d) {
      //  return "al_"+d.id;
      //})
    ;

    //var text = svg.selectAll("text")
    //  .data(treeNode)
    //  .enter().append("text")
    //  .style("font-size", "14px")
    //  .style("font-family", "simsun")
    //  //.style("z-index","100")
    //  .attr("text-anchor","middle")
    //  .on("click", preZoomIn)
    //  .on("mouseenter",update_legend)
    //  .on("mouseout",remove_legend)
    //  .append("textPath")
    //  .attr("startOffset", "20%")
    //  .attr("xlink:href", function(d) {
    //    return '#al_' + d.id;
    //  })
    //  .text(function(d) { return d.name; })
    //  ;

    leftGearT = svg.append("g")
      .datum({radius: Infinity});
    leftGearT.append("g")
      .style("stroke", "gray")
      .style("fill", "#fff")
      .attr("transform", "translate(-275,-219)")
      .datum({teeth: 14, radius: lgs_radius})
      .append("path")
      .attr("d", gear);

    leftGearB = svg.append("g")
      .datum({radius: Infinity});
    leftGearB.append("g")
      .style("stroke", "gray")
      .style("fill", "#fff")
      .attr("transform", "translate(-275,219)")
      .datum({teeth: 14, radius: lgs_radius})
      .append("path")
      .attr("d", gear);

    rightGearT = svg.append("g")
      .datum({radius: Infinity});
    rightGearT.append("g")
      .style("stroke", "gray")
      .style("fill", "#fff")
      .attr("transform", "translate(275,-219)")
      .datum({teeth: 14, radius: lgs_radius})
      .append("path")
      .attr("id", "right_gear")
      .attr("d", gear);

    rightGearB = svg.append("g")
      .datum({radius: Infinity});
    rightGearB.append("g")
      .style("stroke", "gray")
      .style("fill", "#fff")
      .attr("transform", "translate(275,219)")
      .datum({teeth: 14, radius: lgs_radius})
      .append("path")
      .attr("id", "right_gear")
      .attr("d", gear);

    centerGear = svg.append("g")
      .datum({radius: Infinity});
    centerGear.append("g")
      .style("fill-opacity", "0")
      .style("stroke", "gray")
      .style("fill", "#fff")
      .datum({teeth: 84, radius: cg_radius})
      .append("path")
      .attr("d", gear);

    var image = svg.selectAll("image")
      .data(partition.nodes(root).slice(1))
      .enter().append("image")
      .attr("class", "cat")
      .attr("level", "0")
      .attr("id", function(d) { return d.id; })
      .attr("xlink:href", function(d) {
        if (d.img) {
          return d.img;
        } else {
          return "skin/default/image/home/taichi.png";
        }
      })
      .attr("width", "60px")
      .attr("height", "60px")
      .attr("cursor", "pointer")
      .attr("dx", function(d) { return (d.x + d.dx / 2) / Math.PI * 180; })
      .on("click", preZoomIn)
      .on("mouseenter",update_legend)
      .on("mouseout",remove_legend)
      .attr("transform",imgTransformI)
      ;

    var firstId = root._children.slice(0,1)[0].id;
    initArc(firstId, true);
  });

  function preZoomIn(p) {
    var i = 0;
    var rate = ((p.x + p.dx / 2) / Math.PI * 180 + angle)/10;
    function rotate() {
      if (i < 10) {
        i++;
        angle = angle - rate;
        preAngle = angle;
        transformAll();
        setTimeout(rotate, 100);
      } else {
        if (!isRunning) {
          //getCMember(p.id, p.depth);
          $("#c3_l_title")[0].innerText = p.name;
          var svg = d3.select("#d3_1 svg g");
          svg.selectAll(".mem").remove();
          svg.selectAll("circle.cat").remove();
          initArc(p.id, false);
        }
      }
    }
    rotate();
  }

  function preZoomIn2(p) {
    function imgMark() {
      h = 269;
      var r = (p.x + p.dx / 2) / Math.PI * 180 + angle;
      var cosVal = Math.cos((r) * Math.PI / 180), sinVal = Math.sin((r) * Math.PI / 180);
      var x = sinVal * h;
      var y = (-1) * cosVal * h;

      var valTransform = 'matrix(' + cosVal.toFixed(6) + ',' + sinVal.toFixed(6) + ',' + (-1 * sinVal).toFixed(6) + ',' + cosVal.toFixed(6) + ',' + x + ',' + y + ')';//0,0);
      return valTransform ;
    }

    var company = [{dx: p.dx, x: p.x}];
    svg.selectAll("circle.cat").remove();
    var circle = svg.selectAll("circle .cat")
      .data(company).enter()
      .append("circle")
      .attr("class", "cat")
      .attr({cx: 7, cy: 12, r: 35})
      .style({fill: 'none'})
      .style("stroke", p.color)
      .style("stroke-width", "10")
      .attr("transform",imgMark);


    var i = 0;
    var rate = ((p.x + p.dx / 2) / Math.PI * 180 + angle)/10;
    function rotate() {
      if (i < 10) {
        i++;
        angle = angle - rate;
        preAngle = angle;
        transformAll();
        setTimeout(rotate, 100);
      } else {
        if (!isRunning) {
          //getCMember(p.id, p.depth);
          $("#c3_l_title")[0].innerText = p.name;
          var svg = d3.select("#d3_1 svg g");
          getCMember(p.id, p.depth);
        }
      }
    }
    rotate();
  }

  function zoomIn(p, isInit) {
    //if (p._depth && preKey === p.key) {
    //  return;
    //}

    for (var i=p.depth; i<10; i++) {
      if (levelSelect[i])
        //if ($(levelSelect[i]).css("stroke-width") !== '2px') {
          $(levelSelect[i]).css({"stroke": "gray", "fill": "rgb(255, 255, 255)"});
        //} else {
        //  $(levelSelect[p.depth]).css({"stroke": "gray", "stroke-width": "0.5px"});
        //}
      else
        break;
    }
    levelSelect[p.depth] = "#" + p.id;
    //$(levelSelect[p.depth]).css({"fill": "rgb(141, 249, 127)"});
    //if (p.color === '#C4F5BD') {
      $(levelSelect[p.depth]).css({"fill": p.color});
    //} else {
    //  $(levelSelect[p.depth]).css({"stroke": p.color, "stroke-width": "2px"});
    //}

    p._depth = p.depth;
    preKey = p.key;
    if (p._depth == 3 && p._children) {
      //companyShow(p);
      zoom2(p, p, isInit);
      getCMember2(p.id, 3);
    } else if (p._depth != 4){
      zoom(p, p, isInit);
    }
  }

  // Zoom to the specified new root.
  function zoom(root, p, isInit) {
    var tmpDepth = root._depth;
    if (document.documentElement.__transition__) return;

    // Rescale outside angles to match the new layout.
    var enterArc,
      exitArc,
      outsideAngle = d3.scale.linear().domain([0, 2 * Math.PI]);

    //function insideArc(d) {
    //  return p.key > d.key
    //    ? {depth: d.depth - 1, x: 0, dx: 0} : p.key < d.key
    //    ? {depth: d.depth - 1, x: 2 * Math.PI, dx: 0}
    //    : {depth: 0, x: 0, dx: 2 * Math.PI};
    //}

    function outsideArc(d) {
      return {depth: d.depth + 1, x: outsideAngle(d.x), dx: outsideAngle(d.x + d.dx) - outsideAngle(d.x)};
    }

    //center.datum(root);
    //svg.selectAll("text").remove();
    //svg.selectAll(".cat").remove();

    // When zooming in, arcs enter from the outside and exit to the inside.
    // Entering outside arcs start from the old layout.
    if (root === p) {
      enterArc = outsideArc;
      //exitArc = insideArc;
      outsideAngle.range([p.x, p.x + p.dx]);
    } else {
      enterArc = insideArc, exitArc = outsideArc, outsideAngle.range([p.x, p.x + p.dx]);
    }

    var tmpRoot = {};
    $.extend(tmpRoot,root);
    var tmpNodes = partition.nodes(tmpRoot).slice(1).map(function(item){
      var tmpItem = {};
      $.extend(tmpItem,item);
      tmpItem.depth = tmpItem.depth + tmpDepth;
      return tmpItem;
    });
    path = path.data(tmpNodes, function(d) { return d.key; });

    d3.transition().duration(isInit ? 0 : 750).each(function() {
      //path.exit().transition()
      //  .style("fill-opacity", function(d) { return d.depth === 1 + (root === p) ? 1 : 0; })
      //  .attrTween("d", function(d) { return arcTween.call(this, exitArc(d)); })
      //  .remove();

      for (var key in levelPath) {
        if (key >= tmpDepth) {
          svg.selectAll("[level='" + key +"']").remove();
          //levelPath[key].remove();
        }
      }

      levelPath[tmpDepth] = path.enter().append("path")
        .style("fill-opacity", function (d) {
          return d.depth === 2 - (root === p) ? 1 : 0;
        })
        .style("fill", function (d) {
          return d.fill;
        })
        .style("stroke", "gray")
        .style("stroke-width", "0.5")
        .attr("level", tmpDepth)
        .attr("id", function (d) {
          return d.id;
        })
        .attr("cursor", "pointer")
        .on("mouseenter", update_legend)
        .on("mouseout", remove_legend)
        .on("click", preZoomIn)
        .each(function (d) {
          this._current = enterArc(d);
        })
        //.append("path")
        //.attr("d", labelArc)
        //.attr("id", function(d) {
        //  return "al_"+d.id;
        //})
      ;

      currRoot = currRoot.filter(function(item){
        return (item.depth <= tmpDepth);
      });
      currRoot = currRoot.concat(partition.nodes(tmpRoot).slice(1).map(function(item){
        item.depth += tmpDepth;
        return item;
      }));
      //var currKey = [];
      //currRoot = currRoot.filter(function(item){
      //  if (currKey.indexOf(item.key) === -1) {
      //    currKey.push(item.key);
      //    return true;
      //  } else {
      //    return false;
      //  }
      //});

      //var text = svg.selectAll("text")
      //  .data(currRoot)
      //  .enter().append("text")
      //  .attr("class", "cat")
      //  .style("font-size", "14px")
      //  .style("font-family", "simsun")
      //  //.style("z-index","100")
      //  .attr("text-anchor","middle")
      //  .on("click", preZoomIn)
      //  .on("mouseenter",update_legend)
      //  .on("mouseout",remove_legend)
      //  .append("textPath")
      //  .attr("startOffset", "20%")
      //  .attr("xlink:href", function(d) {
      //    //return '#al_' + d.key.replace(/\./gi, "_");
      //    return '#al_' + d.id;
      //  })
      //  .text(function(d) { return d.name; });

      image = svg.selectAll("image .cat")
        .data(tmpNodes)
        .enter().append("image")
        .attr("class", "cat")
        .attr("level", tmpDepth)
        .attr("id", function(d) { return d.id; })
        .attr("xlink:href", function(d) {
          if (d.img) {
            return d.img;
          } else {
            return "skin/default/image/home/taichi.png";
          }
        })
        .attr("width", "50px")
        .attr("height", "50px")
        .attr("cursor", "pointer")
        .on("click", preZoomIn)
        .on("mouseenter",update_legend)
        .on("mouseout",remove_legend)
        .attr("transform",imgTransformI)
      ;

      path.transition()
        .style("fill-opacity", 1)
        .attrTween("d", function(d) { return arcTween.call(this, updateArc(d)); });

      transformAll();

    });
  }

  function zoom2(root, p, isInit) {
    var tmpDepth = root._depth;
    var tmpRoot = {};
    $.extend(tmpRoot,root);
    var tmpNodes = partition.nodes(tmpRoot).slice(1).map(function(item){
      var tmpItem = {};
      $.extend(tmpItem,item);
      tmpItem.depth = tmpItem.depth + tmpDepth;
      return tmpItem;
    });
    path = path.data(tmpNodes, function(d) { return d.key; });

    d3.transition().duration(isInit ? 0 : 750).each(function() {
      for (var key in levelPath) {
        if (key >= tmpDepth) {
          svg.selectAll("[level='" + key +"']").remove();
          //levelPath[key].remove();
        }
      }

      levelPath[tmpDepth] = path.enter();

      currRoot = currRoot.filter(function(item){
        return (item.depth <= tmpDepth);
      });
      currRoot = currRoot.concat(partition.nodes(tmpRoot).slice(1).map(function(item){
        item.depth += tmpDepth;
        return item;
      }));
    });
  }

  function key(d) {
    //var k = [], p = d;
    //while (p.depth) k.push(p.name), p = p.parent;
    //return k.reverse().join(".");
    return d.id.toString();
  }

  function fill(d) {
    var p = d;
    while (p.depth > 1) p = p.parent;
    var c = d3.lab(hue(p.name));
    //c.l = luminance(d.sum);
    c.l = 255;
    return c;
  }

  function setColor(node, color) {
    node.color = color;
    if (node._children) {
      for(var i=0; i<node._children.length; i++) {
        setColor(node._children[i], color);
      }
    }
  }

  function arcTween(b) {
    var i = d3.interpolate(this._current, b);
    this._current = i(0);
    return function(t) {
      return arc(i(t));
    };
  }

  function updateArc(d) {
    return {depth: d.depth, x: d.x, dx: d.dx};
  }

  function pgcheck_code(a,b) {
    $("#1000").click();
  }

  // 进入时默认显示所有子树的第一个项目
  var isRunning = false;
  function initArc(id, isInit) {
    isRunning = true;
    var iTime1 = 500, iTime2 = 100;
    if (!isInit) {
      iTime1 = 100;
      iTime2 = 1000;
    }
    var sub = null;
    function getSub(node) {
      if (node.id == id) {
        sub = node;
        return;
      } else {
        if (node._children) {
          for(var i=0; i<node._children.length; i++) {
            getSub(node._children[i]);
          }
        }
      }
    }
    getSub(rootNode);

    function init() {
      zoomIn(sub, isInit);
      if (sub._children) {
        sub = sub._children.slice(0,1)[0];
        setTimeout(init, iTime2);
      } else {
        isRunning = false;
        if (isInit) {
          //getCMember(sub.id, sub._depth);
          //getCMember(0, sub._depth);
          getCMember(0, 3);
        } else {
          getCMember(id, sub._depth);
        }
      }
    }
    setTimeout(init, iTime1);
  }

  var speed = 1, start = Date.now();
  var step = 0, preAngle = 0;

  var transformAll = function () {
    var transform = function (d) {
      return "rotate(" + angle + ")";
    };
    //var transform2 = function (d) {
    //  return "rotate(" + 0.0001 + ")";
    //};
    var leftGearSTF = function (d) {
      return "rotate(" + -angle * 6 + ")";
    };
    svg.selectAll("path").attr("transform", transform);
    //svg.selectAll("text").attr("transform", transform2);
    //svg.selectAll("text").attr("transform", memberTxtTransformR);
    svg.selectAll("image").attr("transform", imgTransformR);
    svg.selectAll("circle").attr("transform", companyTransform);
    if (leftGearB) {
      leftGearT.selectAll("path").attr("transform", leftGearSTF);
      leftGearB.selectAll("path").attr("transform", leftGearSTF);
      rightGearT.selectAll("path").attr("transform", leftGearSTF);
      rightGearB.selectAll("path").attr("transform", leftGearSTF);
    }
  };

  var transformGear = function () {
    var centerGearTF = function (d) {
      return "rotate(" + -angle + ")";
    };
    var leftGearSTF = function (d) {
      return "rotate(" + angle * 6 + ")";
    };
    if (leftGearB) {
      leftGearT.selectAll("path").attr("transform", leftGearSTF);
      leftGearB.selectAll("path").attr("transform", leftGearSTF);
      rightGearT.selectAll("path").attr("transform", leftGearSTF);
      rightGearB.selectAll("path").attr("transform", leftGearSTF);
      centerGear.selectAll("path").attr("transform", centerGearTF);
    }
  };

  // 驱动svg对象旋转功能
  d3.timer(function() {
    if (!isRotate || !userRotate || step++ < 3) {
      return false;
    } else {
      step = 0;
    }
    //var angle = (Date.now() - start) * speed / radius;
    angle = preAngle + 0.2;
    preAngle = angle;
    transformAll();
  });


  function getCMember(catid, depth) {
    maxDepath = depth;
    makeRequest('action=company&job=bycid&moduleid=4&catid='+catid, AJPath, '_getCMember');
  }

  function getCMember2(catid, depth) {
    maxDepath = depth;
    makeRequest('action=company&job=bycid&moduleid=4&catid='+catid, AJPath, '_getCMember');
  }

  var angleOpertor = function () {
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
        left: Math.cos((180 - deg) / rad2deg) * 30 + 47
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
        transformGear();

        colorBars.removeClass('active').slice(0, numBars).addClass('active');
      }
    });

    $('#control').mouseleave(function(e){
      $(".colorBar").css({display: "none"});
      $(".knob .top").css({display: "none"});
      //$("#right_gear").css({display: "none"});
      rotateOpertor(preRotate);
    });
    $(".colorBar").css({display: "none"});
    $(".knob .top").css({display: "none"});
    $(".knob .base").css({"fill": "grey", "font-size": "14px", "font-weight": "bold"});
    $(".knob .base").html('调整');

    $('#control').mouseenter(function(e){
      preRotate = userRotate;
      //$("#right_gear").css({display: ""});
      rotateOpertor(false);
      $(".colorBar").css({display: ""});
      $(".knob .top").css({display: ""});
    });
  };

  function rotateOpertor(isRotate) {
    userRotate = isRotate;
    transformAll();
  }

  var preRotate = true;
  $("#ct_rotate").click(function(){
    rotateOpertor(!userRotate);
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

  angleOpertor();

  $(".ws0 img").click(function(){
    var svg = d3.select("#d3_1 svg g");
    svg.selectAll(".mem").remove();

    var firstId = rootNode._children.slice(0,1)[0].id;
    initArc(firstId, true);

    $("#c3_l_title")[0].innerText = '全部';
  });

  function companyShow(p) {
    var count = p._children.length;
    if (!count) return;

    var member = [];
    var dx = 2 * Math.PI / count;
    var item = null;

    for (var i=0; i<count; i++) {
      item = p._children[i];
      member.push({id: item.id, dx: dx, x: i*dx, depth: 4, isMember: true
        , name: item.name
        , color: item.color
        //, href: ''
        , img: item.img
      })
    }

    var svg = d3.select("#d3_1 svg g");
    svg.selectAll(".mem").remove();
    var memGear = svg.append("g").attr("class", "mem");

    memGear.selectAll("image .mem")
      .data(member).enter()
      .append("image")
      .attr("class", "img")
      .attr("xlink:href", function(d) {
        if (d.img) {
          return d.img;
        } else {
          return "skin/default/image/home/taichi.png";
        }
      })
      .attr("width", "65px")
      .attr("height", "65px")
      .attr("cursor", "pointer")
      .on("click", preZoomIn2)
      .on("mouseenter", update_legend)
      .on("mouseout", remove_legend)
      .attr("transform", memberTransformI)
      .attr("clip-path", "url(#clip_circle)")
    ;

    setTimeout(function(){
      svg.selectAll("image").attr("transform", imgTransformR);
    }, 100);
  }

})();

var maxDepath = 0;
var isRotate = true;
var userRotate = true;
var angle = 0;
var legend = $("#legend2");
function update_legend(d) {
  isRotate = false;

  if (d.name) {
    //legend.html("<h3 style='margin: 0;text-align: left;'>名称："+d.name+"</h3>")
    if (d.name.length <= 2) {
      legend.parent().attr('x', 25)
    } else if (d.name.length <= 4) {
      legend.parent().attr('x', 11)
    } else {
      legend.parent().attr('x', 0)
    }
    legend.text(d.name);
    legend.stop(true, true).fadeIn();
  }
}
function remove_legend(d) {
  isRotate = true;
  //legend.transition().duration(1000).style("opacity","0");
  legend.stop(true, true).delay(1000).fadeOut();
}

function memberGo(obj) {
  window.open(obj.href );
}

function memberTxtTransformR(d) {
  return memberTxtTransform(d, angle);
}

function memberTxtTransformI(d) {
  return memberTxtTransform(d, 0);
}

function memberTransformI(d) {
  return memberTransform(d, 0, 80);
}

function imgTransformI(d) {
  return imgTransform(d, 0);
}

function imgTransformR(d) {
  if (d.depth == 4 && d.isMember) {
    return memberTransform(d, angle, -20);
  } else {
    return imgTransform(d, angle);
  }
}

function imgTransform(d, angle) {
  h = radius / 4 * (d.depth + 1) - 38;
  var r = (d.x + d.dx / 2) / Math.PI * 180 + angle;
  //既平移也旋转
  //return  "translate(" + arc.centroid(d) + ")" + " rotate(" + r + ")  matrix(1,0,0,1,-16,-35)";
  var cosVal = Math.cos((r) * Math.PI / 180), sinVal = Math.sin((r) * Math.PI / 180);
  //x=r*sinα ，y=-r*cosα
  var x = sinVal * h;
  var y = (-1) * cosVal * h;
  var valTransform = 'matrix(' + cosVal.toFixed(6) + ',' + sinVal.toFixed(6) + ',' + (-1 * sinVal).toFixed(6) + ',' + cosVal.toFixed(6) + ',' + x + ',' + y + ')';//0,0);

  if (d.depth == 1) {
    var hMove = -30;
    var vMove = -10;
  } else {
    var hMove = -25;
    var vMove = 0;
  }
  return valTransform + " matrix(1,0,0,1," + hMove + "," + vMove + ")";
}

function memberTransform(d, angle, offset) {
  h = 269;
  var r = (d.x + d.dx / 2) / Math.PI * 180 + angle;
  var cosVal = Math.cos((r) * Math.PI / 180), sinVal = Math.sin((r) * Math.PI / 180);
  var x = sinVal * h;
  var y = (-1) * cosVal * h;
  //var valTransform = 'matrix(1,0,0,1,' + x + ',' + y + ')';//0,0);
  var valTransform = 'matrix(' + cosVal.toFixed(6) + ',' + sinVal.toFixed(6) + ',' + (-1 * sinVal).toFixed(6) + ',' + cosVal.toFixed(6) + ',' + x + ',' + y + ')';//0,0);
  return valTransform + " matrix(1,0,0,1,-25," + offset + ")";
}

function companyTransform(d) {
  if (!d) return;
  h = 269;
  var r = (d.x + d.dx / 2) / Math.PI * 180 + angle;
  var cosVal = Math.cos((r) * Math.PI / 180), sinVal = Math.sin((r) * Math.PI / 180);
  var x = sinVal * h;
  var y = (-1) * cosVal * h;
  var valTransform = 'matrix(' + cosVal.toFixed(6) + ',' + sinVal.toFixed(6) + ',' + (-1 * sinVal).toFixed(6) + ',' + cosVal.toFixed(6) + ',' + x + ',' + y + ')';//0,0);
  return valTransform ;
}

function memberTxtTransform(d, angle) {
  h = 220;
  var r = (d.x + d.dx / 2) / Math.PI * 180 + angle;
  var cosVal = Math.cos((r) * Math.PI / 180), sinVal = Math.sin((r) * Math.PI / 180);
  var x = sinVal * h;
  var y = (-1) * cosVal * h;
  //var valTransform = 'matrix(1,0,0,1,' + x + ',' + y + ')';//0,0);
  var valTransform = 'matrix(' + cosVal.toFixed(6) + ',' + sinVal.toFixed(6) + ',' + (-1 * sinVal).toFixed(6) + ',' + cosVal.toFixed(6) + ',' + x.toFixed(6) + ',' + y.toFixed(6) + ')';//0,0);
  return valTransform + 'matrix(1,0,0,1,8,0)';
}

function memberShow() {
  var count = $("#CMember").children().length;
  if (!count) return;

  var member = [];
  var dx = 2 * Math.PI / count;
  var item = null;

  for (var i=0; i<count; i++) {
    item = $("#CMember").children().eq(i);
    member.push({dx: dx, x: i*dx, depth: 4, isMember: true, level: 0
      , name: item.find(".group-name").html()
      , href: item.find("a").attr("href")
      , img: item.find("img").attr("src").replace('size=middle','size=large')});
  }

  var svg = d3.select("#d3_1 svg g");
  svg.selectAll(".mem").remove();
  var memGear = svg.append("g").attr("class", "mem");

  memGear.selectAll("image .mem")
    .data(member).enter()
    .append("image")
    .attr("class", "img")
    .attr("xlink:href", function (d) { return d.img; })
    .attr("width", "65px")
    .attr("height", "65px")
    .attr("cursor", "pointer")
    .on("click", memberGo)
    .on("mouseenter", update_legend)
    .on("mouseout", remove_legend)
    .attr("transform", memberTransformI)
    .attr("clip-path", "url(#clip_circle)")
  ;

  //memGear.selectAll("image .mem")
  //  .data(member).enter()
  //  .append("image")
  //  .attr("class", "img")
  //  .attr("xlink:href", "skin/default/image/home/member_filter.png")
  //  .attr("width", "66px")
  //  .attr("height", "66px")
  //  .attr("cursor", "pointer")
  //  .on("click", memberGo)
  //  .on("mouseenter", update_legend)
  //  .on("mouseout", remove_legend)
  //  .attr("transform", memberTransformI)
  //;

  //memGear.selectAll("text")
  //  .data(member).enter()
  //  .append("text")
  //  .attr("class", "mem")
  //  .style("font-size", "16px")
  //  .style("font-family", "simsun")
  //  //.style("font-weight", "bolder")
  //  .attr("text-anchor","middle")
  //  .on("click", memberGo)
  //  .on("mouseenter", update_legend)
  //  .on("mouseout", remove_legend)
  //  .attr("transform", memberTxtTransformI)
  //  .text(function(d) { return d.level; })
  //;

  setTimeout(function(){
    //svg.selectAll("text").attr("transform", memberTxtTransformR);
    svg.selectAll("image").attr("transform", imgTransformR);
  }, 100);

}

var buyerquee = null;
var buyer_seri = 0;
var buyer_name = 'buyer';
function _getCMember() {
  var newData = false;
  if(xmlHttp.readyState==4 && xmlHttp.status==200) {
    if (xmlHttp.responseText && xmlHttp.responseText != 'nodata') {
      newData = true;
    }
  } else {
    return;
  }

  var newHtml = '';
  if (!newData) {
    newHtml = Dd('CMemberTop20').innerHTML;
  } else {
    newHtml = xmlHttp.responseText;
  }
  if (maxDepath < 4) {
    $("#CMember").empty();
    Dd('CMember').innerHTML = newHtml;
    memberShow();
  }

  if (newHtml.length != $("#" + buyer_name + " .mthumb")[0].innerHTML.length) {
    $("#" + buyer_name).empty();
    buyer_seri = buyer_seri + 1;
    $("#" + buyer_name).attr('id', 'buyer' + buyer_seri);
    buyer_name = 'buyer' + buyer_seri;
    $("#" + buyer_name).append('<div class="mthumb" style="margin: 5px 0 0 0;"></div>');
    $("#" + buyer_name + " .mthumb")[0].innerHTML = newHtml;

    if (buyerquee) {
      clearInterval(buyerquee.timer);
      clearInterval(buyerquee.t);
    }
    buyerquee = new dmarquee2(45, 30, 3000, buyer_name);
  }

}
