$(document).ready(function() {

    //物业、车辆信息添加、修改JS	

    $(".imagup_delimg").live('click',
    function() {
        var pic = $(this).attr("rel");
        $.post("/wx-pages/wx_property_do.php?act=delimg", {
            imagename: pic
        },
        function(msg) {
            if (msg == 1) {
                files.html("删除成功.");
                showimg.empty();
                progress.hide();
            } else {
                alert(msg);
            }
        });
    });

    $("#wx_car").click(function() {
        location.href = "/wx-pages/wx_car.php";
    });

    $("#sp_del").live('click',
    function() {
        if (confirm('确定删除?')) {
            var propertyID = $(this).attr("rel");
            $.post("/wx-pages/wx_property_do.php?act=property_del", {
                propertyID: propertyID
            },
            function(msg) {
                if (msg == 1) {
                    //$("#le_del").show().html("编号："+propertyID+",删除成功！" );
                    alert("删除成功！");
                    history.go( - 1);
                } else {
                    alert(msg);
                }
            });
        }
    });

});

/**
 *表单验证
 */
function submitValidate_p() {
    var aStr = $("#a").val();
    if (aStr == undefined || aStr == "" || aStr == null) {
        noticeDialog("没有填写物业所有人");
        return;
    }
    if (delSpace(aStr).length < 2 || delSpace(aStr).length > 20) {
        noticeDialog("请填写真实姓名");
        return;
    }
    var bStr = $("#b").val();
    if (bStr == undefined || bStr == "" || bStr == null) {
        noticeDialog("没有填写联系人");
        return;
    }
    if (delSpace(bStr).length < 2 || delSpace(bStr).length > 20) {
        noticeDialog("请填写真实姓名");
        return;
    }

    var cStr = $("#c").val();
    if (!isPositiveNumber2(cStr)) {
        noticeDialog("请按示例正确填写固定电话");
        return;
    }
    var dStr = $("#d").val();
    if (!isPositiveNumber2(dStr)) {
        noticeDialog("请正确填写移动电话");
        return;
    }
    if ((cStr == undefined || cStr == "" || cStr == null) && (dStr == undefined || dStr == "" || dStr == null)) {
        noticeDialog("固定电话或移动电话至少填一个");
        return;
    }

    var eStr = $("#e").val();
    if (delSpace(eStr).length < 6 || delSpace(eStr).length > 100) {
        noticeDialog("请填写房产证上的地址");
        return;
    }

    var fStr = $("#f").val();
    if (!isPositiveNumber(fStr)) {
        noticeDialog("房屋面积请填写一个整数值");
        return;
    }

    var hStr = $("#couponid").val();
    if (hStr == 0) {
        noticeDialog("请选择房屋户型");
        return;
    }
    var uptype = $("#uptype").val();
    isupdata("p", uptype);
}

function submitValidate_c() {
    var aStr = $("#a").val();
    if (aStr == undefined || aStr == "" || aStr == null) {
        noticeDialog("没有填写车辆所有人");
        return;
    }
    if (delSpace(aStr).length < 2 || delSpace(aStr).length > 20) {
        noticeDialog("请填写真实姓名");
        return;
    }
    var bStr = $("#b").val();
    if (bStr == undefined || bStr == "" || bStr == null) {
        noticeDialog("没有填写联系人");
        return;
    }
    if (delSpace(bStr).length < 2 || delSpace(bStr).length > 20) {
        noticeDialog("请填写真实姓名");
        return;
    }

    var cStr = $("#c").val();
    if (!isPositiveNumber2(cStr)) {
        noticeDialog("请按示例正确填写固定电话");
        return;
    }
    var dStr = $("#d").val();
    if (!isPositiveNumber2(dStr)) {
        noticeDialog("请正确填写移动电话");
        return;
    }
    if ((cStr == undefined || cStr == "" || cStr == null) && (dStr == undefined || dStr == "" || dStr == null)) {
        noticeDialog("固定电话或移动电话至少填一个");
        return;
    }

    var eStr = $("#e").val();
    if (!isPositiveNumber(eStr) || delSpace(eStr).length != 8) {
        noticeDialog("请正确填写8位日期");
        return;
    }
    var fStr = $("#f").val();
    if (fStr == undefined || fStr == "" || fStr == null) {
        noticeDialog("请正确车辆型号");
        return;
    }
    var gStr = $("#g").val();
    if (gStr == undefined || gStr == "" || gStr == null) {
        noticeDialog("请上传行驶证");
        return;
    }
    var uptype = $("#uptype").val();
    isupdata("c", uptype);
}

function isPositiveNumber(txt) { //是否为正数
    if (txt == null || txt == "") {
        return false;
    } else {
        txt = delSpace(txt);
        if (isNaN(txt)) {
            return false;
        } else {
            return (parseInt(txt) > 0);
        }
    }
}

function isPositiveNumber2(txt) { //是否为正数
    if (txt == null || txt == "") {
        return true;
    } else {
        txt = delSpace(txt);
        if (delSpace(txt).length < 8 || delSpace(txt).length > 12) {
            return false;
        }
        if (isNaN(txt)) {
            return false;
        } else {
            return (parseInt(txt) > 0);
        }
    }
}

function delSpace(txt) { //清除字符串中所有的空白字符
    if (txt == null) {
        return "";
    } else {
        txt = txt.toString();
        txt = txt.replace(/\s{1,}/, "");
        return txt;
    }
}

function isupdata(ptype, uptype) { //数据检查之后的ajax提交事件
    //开始发送数据
    $.ajax({ //请求登录处理页
        url: "/wx-pages/wx_property_do.php",
        //处理页
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: "text",
        //传送请求数据
        data: $('#fm1').serialize(),
        success: function(strValue) { //登录成功后返回的数据
            //根据返回值进行状态显示
            //alert(strValue);
            if ($.trim(strValue) == "True") { //注意是True,不是true
                if (ptype == "p") {
                    if (uptype == "new") noticeDialog("物业添加成功！我们将尽快进行认证", 4000);
                    if (uptype == "update") noticeDialog("物业修改成功！我们将尽快进行认证", 4000);
                    $("#clsShow").show().html("<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/';\">预订服务</button> &nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/wx_property.php';\">继续添加</button>");
                }
                if (ptype == "c") {
                    if (uptype == "new") noticeDialog("车辆添加成功！");
                    if (uptype == "update") noticeDialog("车辆修改成功！");
                    $("#clsShow").show().html("<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/';\">预订服务</button> &nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/wx_car.php';\">继续添加</button>");
                }
                $("#property_updata").hide();
            } else {
                $("#clsShow").show().html("未知错误！");
            }
        },
        error: function(data) {
            alert("error:" + data.responseText);
        }
    });
    return false;
};

//审核物业信息
function submitApproved_p(property_ID, approved) {
    $.ajax({ //请求登录处理页
        url: "/wx-pages/wx_property_do.php?act=approvedup",
        //处理页
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: "text",
        //传送请求数据
        data: {
            property_ID: property_ID,
            approved: approved
        },
        success: function(strValue) { //登录成功后返回的数据
            //根据返回值进行状态显示
            if ($.trim(strValue) == "True") { //注意是True,不是true
                noticeDialog("操作成功", 4000);
                window.location.reload(); //刷新当前页面
            } else {
                noticeDialog("操作失败！", 4000);
            }
        },
        error: function(data) {
            alert("error:" + data.responseText);
        }
    });
    return false;
};
//物业、车辆信息添加、修改JS	 END

//深度清洁服务JS
var realityAllDcPrice = 0;
var originalAllDcPrice = 0;

function noticeDialog(content, millisecond) {
    if (!millisecond) {
        millisecond = 1000;
    }
    if ($("#noticeDialog")) {
        $("#noticeDialog").remove();
    }
    //var top = $(window).height() / 2 - 27;
    var top = window.scrollY + $(window).height() / 2 - 27;
    var noticeDiv = '<div id="noticeDialog"' + 'style="position: absolute; outline: 0px; top: ' + top + 'px; z-index: 1024;">' + '<div style="position: relative;border-radius: 9px;outline: 0;background-clip: padding-box;font-size: 14px;line-height: 1.428571429;color: #FFF;opacity: 0;-webkit-transform: scale(0);' + 'transform: scale(0);-webkit-transition: -webkit-transform .20s ease-in-out, opacity .20s ease-in-out;transition: transform .20s ease-in-out, opacity .20s ease-in-out;' + '-moz-opacity:0.7;filter:alpha(opacity=70);background-color:#000;font-weight:bold;opacity: 1; -webkit-transform: scale(1); transform: scale(1);">' + '<table>' + '<tr>' + '<td style="padding: 15px;text-align: center;"><div>' + content + '</div></td>' + '</tr>' + '</table>' + '</div>' + '</div>';

    $("body").append(noticeDiv);
    var left = ($(window).width() - $("#noticeDialog").width()) / 2;
    $("#noticeDialog").css("left", left);
    setTimeout("$('#noticeDialog').remove()", millisecond);
}

function delUnit(id, dcPrice) {
    var unitidval = $("#unitid" + id).val();
    if (Number(unitidval) == 0) {
        return;
    }
    var num = Number(unitidval) - 1;
    if (num <= 0) {
        num = 0;
        $("#numtable" + id).addClass("table-disabled");
    }
    $("#unitid" + id).val(num);
    $("#num" + id).html("x" + num);
    delPrice(dcPrice * discount / 100 + "," + dcPrice);
    if (num <= 0) {
        //changeCoupons(cateid);
    }
    //alert(getUnits());
    $("#service").val(getUnits());
}

function addUnit(id, dcPrice) { //增加当前单元
    var unitidval = $("#unitid" + id).val();
    if (Number(unitidval) == 0) {
        $("#numtable" + id).removeClass("table-disabled");
    }
    if (Number(unitidval) < 9) {
        var num = Number(unitidval) + 1;
        $("#unitid" + id).val(num);
        $("#num" + id).html("x" + num);
        addPrice(dcPrice * discount / 100 + "," + dcPrice);
    }
    if (Number(unitidval) == 0) {
        //changeCoupons(dcPrice);
    }
    //alert(getUnits());
    $("#service").val(getUnits());
}

/**
 *获取当前价格
 */
function addPrice(strPrice) {
    //alert(strPrice);
    var prices = strPrice.split(",");
    if (prices.length == 2 && Number(prices[0]) == 0 && Number(prices[1]) == 0) {
        $("#realityprice").html("");
        $("#originalprice").html("");
        $("#total_fee").val(0);
        $("#cash_fee").val(0);
    } else if (prices.length == 2) {
        if (prices[0] == prices[1]) {
            realityAllDcPrice += parseInt(prices[0]);
            $("#realityprice").html(realityAllDcPrice + "元");
            $("#originalprice").html("");
            $("#total_fee").val(realityAllDcPrice * 100);
            $("#cash_fee").val(realityAllDcPrice * 100);
        } else {
            realityAllDcPrice += parseInt(prices[0]);
            originalAllDcPrice += parseInt(prices[1]);
            $("#realityprice").html(realityAllDcPrice + "元");
            $("#originalprice").html(originalAllDcPrice + "元");
            $("#total_fee").val(originalAllDcPrice * 100);
            $("#cash_fee").val(realityAllDcPrice * 100);
        }
    } else {
        $("#realityprice").html("");
        $("#originalprice").html("");
        $("#total_fee").val(0);
        $("#cash_fee").val(0);
    }
}

function delPrice(strPrice) {
    var prices = strPrice.split(",");
    if (prices.length == 2 && Number(prices[0]) == 0 && Number(prices[1]) == 0) {
        $("#realityprice").html("");
        $("#originalprice").html("");
        $("#total_fee").val(0);
        $("#cash_fee").val(0);
    } else if (prices.length == 2) {
        if (prices[0] == prices[1]) {
            realityAllDcPrice -= parseInt(prices[0]);
            $("#realityprice").html(realityAllDcPrice + "元");
            $("#originalprice").html("");
            $("#total_fee").val(realityAllDcPrice * 100);
            $("#cash_fee").val(realityAllDcPrice * 100);
        } else {
            realityAllDcPrice -= parseInt(prices[0]);
            originalAllDcPrice -= parseInt(prices[1]);
            $("#realityprice").html(realityAllDcPrice + "元");
            $("#originalprice").html(originalAllDcPrice + "元");
            $("#total_fee").val(originalAllDcPrice * 100);
            $("#cash_fee").val(realityAllDcPrice * 100);
        }
    } else {
        $("#realityprice").html("");
        $("#originalprice").html("");
        $("#total_fee").val(0);
        $("#cash_fee").val(0);
    }
}

$(document).ready(function() {
    //房管家订单
    $(".addressjs").click(function() {
        $(".addressjs").removeClass("typeClick");
        $(this).addClass("typeClick");
        strID = $(this).data("ID");
        $("#property_ID").val(strID);
        //alert($("#address").val());
    });

    $(".addressonejs").click(function() {
        $(".addressonejs").removeClass("typeClick");
        $('#period option[value=12]').attr('selected', true);
        $('#frequency option[value=1]').attr('selected', true);
        $(this).addClass("typeClick");
        strID = $(this).data("ID");
        area = $(this).data("f");
        tprice = area * 200 * 12;
        if (area <= 200) {
            cprice = 0; //一年免费
            noticeDialog("免费赠送一年12次房管家服务！", 5000);
            $(".card .coupons").show();
            $("#period option[value=12]").html("服务期限（一年，赠送）") 
			$("#frequency option[value=1]").html("每月频次（一次，赠送）");
        } else {
            cprice = tprice * discount / 100;
            noticeDialog("服务价格计算公式：<br/>2元/平米x" + area + "平米x12次x" + discount / 10 + "折=" + parseInt(cprice * 0.01) + "元", 5000);
            $(".card .coupons").hide();
            $("#period option[value=12]").html("服务期限（一年）") 
			$("#frequency option[value=1]").html("每月频次（一次）");
        }
        $("#property_ID").val(strID);
        $("#service").val('{"00":1}');
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }

    });

    $("#period").bind("change",
    function() {
        period = $(this).val();
        if (period > 12) {
            $("#frequency option[value=1]").html("每月频次（一次）");
        }
        if (period == 12) {
            $("#frequency option[value=1]").html("每月频次（一次，赠送）");
        }
        frequency = $("#frequency").val();
        tprice = area * 200 * frequency * period;
        if (area <= 200) {
            fprice = tprice - area * 200 * 12;
            cprice = fprice * discount / 100;
            noticeDialog("服务价格计算公式：<br/>2元/平米x" + area + "平米x" + period + "个月x" + frequency + "次x" + discount / 10 + "折-赠送包=" + parseInt(cprice * 0.01) + "元", 5000);
        } else {
            fprice = tprice;
            cprice = fprice * discount / 100;
            noticeDialog("服务价格计算公式：<br/>2元/平米x" + area + "平米x" + period + "个月x" + frequency + "次x" + discount / 10 + "折=" + parseInt(cprice * 0.01) + "元", 5000);
        }
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }
    });

    $("#frequency").bind("change",
    function() {
        period = $("#period").val();
        frequency = $(this).val();
        tprice = area * 200 * frequency * period;
        if (area <= 200) {
            fprice = tprice - area * 200 * 12;
            cprice = fprice * discount / 100;
            noticeDialog("服务价格计算公式：<br/>2元/平米x" + area + "平米x" + period + "个月x" + frequency + "次x" + discount / 10 + "折-赠送包=" + parseInt(cprice * 0.01) + "元", 5000);
        } else {
            fprice = tprice;
            cprice = fprice * discount / 100;
            noticeDialog("服务价格计算公式：<br/>2元/平米x" + area + "平米x" + period + "个月x" + frequency + "次x" + discount / 10 + "折=" + parseInt(cprice * 0.01) + "元", 5000);
        }
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }
    });

    //住前打理
    $(".addressfrontjs").click(function() {
        $(".addressfrontjs").removeClass("typeClick");
        $(this).addClass("typeClick");
        strID = $(this).data("ID");
        area = $(this).data("f");
        tprice = area * 500;
        cprice = tprice;
        //cprice = tprice*discount/100;
        $("#property_ID").val(strID);
        $("#service").val('{"00":1}');
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }

    });

    //住后整理
    $(".addressafterjs").click(function() {
        $(".addressafterjs").removeClass("typeClick");
        $(this).addClass("typeClick");
        strID = $(this).data("ID");
        area = $(this).data("f");
        tprice = area * 400;
        cprice = tprice;
        //cprice = tprice*discount/100;
        $("#property_ID").val(strID);
        $("#service").val('{"00":1}');
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html(parseInt(cprice / 100) + "元");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }

    });

    //车管家服务
    $(".carservjs").click(function() {
        $(".carservjs").removeClass("typeClick");
        $(this).addClass("typeClick");
        //获取服务类型
        var typeid = $(this).data("t");
		servicetemp1 = "";
		servicetemp2 = "";
		//取消可选服务选中状态
		$("#car_clean").attr("checked",false);
		$("#car_filling").attr("checked",false);
        if (typeid == 50) {
            //获取保养类型
            var baoy = $('.baoy input[name="car_serv"]:checked ').val();
            if (baoy == 51) {
                tprice = 10000;
				typechild = 51;
            }
            if (baoy == 52) {
                tprice = 20000;
				typechild = 52;
            }
            if (baoy == 53) {
                tprice = 20000;
				typechild = 53;
            }
            $(".baoy").show();
        }
        if (typeid == 60) {
            tprice = 5000;
            $(".baoy").hide();
			typechild = 60;
        }
        if (typeid == 70) {
            tprice = 10000;
            $(".baoy").hide();
			typechild = 70;
        }
        cprice = tprice * discount / 100;
		//车管家基本服务
        if (typeid != "" && typeid != undefined){ 
		   servicetemp1 = '"' + typeid + '":' + typechild;
		}
		//计算总价格
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html("<span style='font-size:14px'>服务费：" + parseInt(cprice / 100) + "元<br\/>第三方费用服务前将与您电话确认<\/span>");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html("<span style='font-size:14px'>服务费：" + parseInt(cprice / 100) + "元<br\/>第三方费用服务前将与您电话确认<\/span>");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }
    });
	
    //获取保养类型，重新计算服务费
    $(".bytype").click(function() {
        var typeid = $(this).data("t");
        var baoyt = $('.baoy input[name="car_serv"]:checked ').val();
        if (baoyt == 51) {
            tprice = 10000;
        }
        if (baoyt == 52) {
            tprice = 20000;
        }
        if (baoyt == 53) {
            tprice = 20000;
        }
		if (typeid != "" && baoyt != "" && typeid != undefined && baoyt != undefined){ 
          servicetemp1 = '"' + typeid + '":' + baoyt;
		}
		cprice = tprice * discount / 100;
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html("<span style='font-size:14px'>服务费：" + parseInt(cprice / 100) + "元<br\/>第三方费用服务前将与您电话确认<\/span>");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html("<span style='font-size:14px'>服务费：" + parseInt(cprice / 100) + "元<br\/>第三方费用服务前将与您电话确认<\/span>");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }

    });
	
	//车管家可选服务 加油 洗车
    $(".addit_serv").change(function() {
		var car_clean = $('.addit_servli input:checkbox[name="car_clean"]:checked ').val();
		if (car_clean != "" && car_clean != undefined){ 
		   servicetemp2 = '"' + car_clean + '":' + car_clean;
		}
		var car_filling = $('.addit_servli input:checkbox[name="car_filling"]:checked ').val();
		if (car_filling != "" && car_filling != undefined){ 
		   servicetemp2 += ',"' + car_filling + '":' + car_filling;
		}
	});

    $(".carjs").click(function() {
        $(".carjs").removeClass("typeClick");
        $(this).addClass("typeClick");
		strID = $(this).data("ID");
		$("#property_ID").val(strID);

    });
	
	$(".houseservice").click(function() {
        $(".houseservice").removeClass("typeClick");
        $(this).addClass("typeClick");

    });
	
	//生活管家服务
	$(".lifeservjs").click(function() {
        $(".lifeservjs").removeClass("typeClick");
        $(this).addClass("typeClick");
        //获取服务类型
        var typeid = $(this).data("t");
		servicetemp1 = "";
		servicetemp2 = "";
		if (typeid == 101) {
			$(".life_house").show();
			$(".life_car").hide();
			tprice = 10000;
		}
		if (typeid == 102) {
			$(".life_house").hide();
			$(".life_car").show();
			tprice = 10000;
		}
		if (typeid == 103) {
			$(".life_house").show();
			$(".life_car").hide();
			tprice = 5000;
		}
		if (typeid == 104) {
			$(".life_house").hide();
			$(".life_car").hide();
			tprice = 10000;
		}
		cprice = tprice * discount / 100;
        $("#total_fee").val(tprice);
        $("#cash_fee").val(cprice);
        if (cprice == tprice) {
            $("#realityprice").html("<span style='font-size:14px'>服务费：" + parseInt(cprice / 100) + "元<br\/>第三方费用服务前将与您电话确认<\/span>");
            $("#originalprice").html("");
        } else {
            $("#realityprice").html("<span style='font-size:14px'>服务费：" + parseInt(cprice / 100) + "元<br\/>第三方费用服务前将与您电话确认<\/span>");
            $("#originalprice").html(parseInt(tprice / 100) + "元");
        }
	});

    $(".life_addressonejs").click(function() {
        $(".life_addressonejs").removeClass("typeClick");
        $(this).addClass("typeClick");

    });
	$(".life_carjs").click(function() {
        $(".life_carjs").removeClass("typeClick");
        $(this).addClass("typeClick");

    });
});

/**
 *提交订单验证
 */
function submitValidate() {
    var unitsStr = getUnits();
    if (unitsStr == undefined || unitsStr == "" || unitsStr == null) {
        noticeDialog("没有选择服务内容");
        return;
    }
    var address = $("#property_ID").val();
    if (address == undefined || address == "" || address == null) {
        noticeDialog("没有选择物业");
        return;
    }
    var time = $("#time_serv").val();
    if (time == undefined || time == "" || time == null) {
        noticeDialog("没有选择时间");
        return;
    }
    isupservice();
}

function submitOneValidate() {
    var address = $("#property_ID").val();
    if (address == undefined || address == "" || address == null) {
        noticeDialog("没有选择物业");
        return;
    }
    var time = $("#time_serv").val();
    if (time == undefined || time == "" || time == null) {
        noticeDialog("没有选择时间");
        return;
    }
    isupservice();
}

//车管家提交
function submitCarValidate() {
	if (servicetemp1 == undefined || servicetemp2 == undefined) {
        noticeDialog("没有选择车管家服务");
        return;
    }
	if(servicetemp1!=""&&servicetemp1!=undefined){
		if(servicetemp2!=""&&servicetemp2!=undefined){
			$("#service").val("{"+servicetemp1+","+servicetemp2+"}");	
		}else{
			$("#service").val("{"+servicetemp1+"}");
		}
	}
	var cartype = $("#service").val();
    if (cartype == undefined || cartype == "" || cartype == null) {
        noticeDialog("没有选择车管家服务");
        return;
    }
	var car = $("#property_ID").val();
    if (car == undefined || car == "" || car == null) {
        noticeDialog("没有选择车辆");
        return;
    }
    var time = $("#time_serv").val();
    if (time == undefined || time == "" || time == null) {
        noticeDialog("没有选择时间");
		$("input[name='time_serv']").focus();
        return;
    }
	var remarks = $("#remarks").val();
    if (remarks == undefined || remarks == "" || remarks == null) {
        noticeDialog("没有填写取车地址和联系方式");
		$("input[name='remarks']").focus();
        return;
    }
    isupservice();
}

function isupservice() { //数据检查之后的ajax提交事件
    //开始发送数据
    $.ajax({ //请求登录处理页
        url: "/wx-pages/wx_servorder_do.php",
        //处理页
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: "text",
        //传送请求数据
        data: $('#fm1').serialize(),
        success: function(strValue) { //登录成功后返回的数据
            //根据返回值进行状态显示
            strValue = $.trim(strValue);
            var strs = new Array(); //定义一数组 
            strs = strValue.split(":"); //字符分割 
            if (strs[0] == "True") { //注意是True,不是true
                //noticeDialog("预定成功，后续会有专人与您联系！");
                $('#orderbt').attr("disabled", true);
                //清空状态数据
                realityAllDcPrice = 0;
                originalAllDcPrice = 0;
                units = "";
                $("#onup input").val(0);
                $(".ipt").val("");
                //跳转到成功页面
                window.location.href = '/wx-pages/wx_ordersuccess.php?order_ID=' + strs[1];
            } else if (strs[0] == "余额不足") {

                if (confirm("余额不足，是否充值？")) {
                    location.href = "/wx-pages/wx_member.php";
                } else {
                    location.href = "/wx-pages/";
                }
                //noticeDialog("余额不足，请充值！");
                //$(".addressjs").html(strValue);
            } else {
                noticeDialog("预订不成功，请联系我们！", 10000000000);
            }
        },
        error: function(data) {
            //alert("error:"+data.responseText);
            noticeDialog("内部错误，请联系我们！");
        }
    });
    return false;
};
//深度清洁服务JS END
