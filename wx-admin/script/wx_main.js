$(document).ready(function() {
    
//物业、车辆信息添加、修改JS	
	var bar = $('.imagup_bar');
    var percent = $('.imagup_percent');
    var showimg = $('#showimg');
    var progress = $(".imagup_progress");
    var files = $(".imagup_files");
    var btn = $(".imagup_btn span");

    $("#fileupload").wrap("<form id='myupload' action='/wx-pages/wx_property_do.php' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function() {
        $("#myupload").ajaxSubmit({
            dataType: 'json',
            beforeSend: function() {
                showimg.empty();
                progress.show();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
                btn.html("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function(data) {
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <span class='imagup_delimg' rel='" + data.pic + "'>删除</span>");
                var img = "/wx-pages/uploads/" + data.pic;
                showimg.html("<img src='" + img + "' width='100%'>");
                $("#g").val(img);
                btn.html("添加附件");
            },
            error: function(xhr) {
                btn.html("上传失败");
                bar.width("0");
                files.html(xhr.responseText);
            }
        });
    });

    $(".imagup_delimg").live('click', function() {
        var pic = $(this).attr("rel");
        $.post("/wx-pages/wx_property_do.php?act=delimg", {
            imagename: pic
        }, function(msg) {
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

    $("#sp_del").live('click', function() {
        if (confirm('确定删除?')) {
            var propertyID = $(this).attr("rel");
            $.post("/wx-pages/wx_property_do.php?act=property_del", {
                propertyID: propertyID
            }, function(msg) {
                if (msg == 1) {
                    //$("#le_del").show().html("编号："+propertyID+",删除成功！" );
                    alert("删除成功！");
					history.go(-1);
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
    isupdata("p",uptype);
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
    isupdata("c",uptype);
}


function isPositiveNumber(txt) { //是否为正数
    if (txt == null || txt == "") {
        return false;
    } else {
        txt = delSpace(txt);
        if (isNaN(parseInt(txt))) {
            return false;
        } else {
            return (parseInt(txt) > 0);
        }
    }
}

function isPositiveNumber2(txt) { //是否为正数
    if (txt == null || txt == "") {
        return false;
    } else {
        txt = delSpace(txt);
        if (delSpace(txt).length < 8 || delSpace(txt).length > 12) {
            return false;
        }
        if (isNaN(parseInt(txt))) {
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

function isupdata(ptype,uptype) { //数据检查之后的ajax提交事件
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
					if(uptype == "new")
					noticeDialog("物业添加成功！");
					if(uptype == "update")
					noticeDialog("物业修改成功！");
                    $("#clsShow").show().html("<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/';\">预订服务</button> &nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/wx_property.php';\">继续添加</button> &nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/wx_car.php';\">添加车辆</button>");
                }
                if (ptype == "c") {
                    if(uptype == "new")
					noticeDialog("车辆添加成功！");
					if(uptype == "update")
					noticeDialog("车辆修改成功！");
                    $("#clsShow").show().html("<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/';\">预订服务</button> &nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/wx_car.php';\">继续添加</button> &nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-positive btn-positive2' type='button' style='background-color:#825623; border-color:#825623'  onclick=\"javascript:location.href='/wx-pages/wx_property.php';\">添加物业</button>");
                }
                $("#property_updata").hide();
                //$(".ipt").attr("disabled", true);
                //$(".ipt").css("border", "1px #FBFBFB");
                //$(".ipt").css("background", "#FBFBFB");
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
	var top =  window.scrollY +  $(window).height() / 2 - 27; 
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
	delPrice(dcPrice*discount/100+","+dcPrice);
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
	if(Number(unitidval) < 9){
		var num = Number(unitidval) + 1;
		$("#unitid" + id).val(num);
		$("#num" + id).html("x" + num);
		addPrice(dcPrice*discount/100+","+dcPrice);
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
	if (prices.length == 2 && Number(prices[0]) == 0 && Number(prices[1]) == 0){
		$("#realityprice").html("");
		$("#originalprice").html("");
		$("#total_fee").val(0);
		$("#cash_fee").val(0);
	}else if (prices.length == 2) {
		if (prices[0] == prices[1]) {
			realityAllDcPrice += parseInt(prices[0]);
			$("#realityprice").html(realityAllDcPrice + "元");
			$("#originalprice").html("");
			$("#total_fee").val(realityAllDcPrice*100);
			$("#cash_fee").val(realityAllDcPrice*100);
		} else {
			realityAllDcPrice += parseInt(prices[0]);
			originalAllDcPrice += parseInt(prices[1]);
			$("#realityprice").html(realityAllDcPrice + "元");
			$("#originalprice").html(originalAllDcPrice + "元");
			$("#total_fee").val(originalAllDcPrice*100);
			$("#cash_fee").val(realityAllDcPrice*100);
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
	if (prices.length == 2 && Number(prices[0]) == 0 && Number(prices[1]) == 0){
		$("#realityprice").html("");
		$("#originalprice").html("");
		$("#total_fee").val(0);
		$("#cash_fee").val(0);
	}else if (prices.length == 2) {
		if (prices[0] == prices[1]) {
			realityAllDcPrice -= parseInt(prices[0]);
			$("#realityprice").html(realityAllDcPrice + "元");
			$("#originalprice").html("");
			$("#total_fee").val(realityAllDcPrice*100);
			$("#cash_fee").val(realityAllDcPrice*100);
		} else {
			realityAllDcPrice -= parseInt(prices[0]);
			originalAllDcPrice -= parseInt(prices[1]);
			$("#realityprice").html(realityAllDcPrice + "元");
			$("#originalprice").html(originalAllDcPrice + "元");
			$("#total_fee").val(originalAllDcPrice*100);
			$("#cash_fee").val(realityAllDcPrice*100);
		}
	} else {
		$("#realityprice").html("");
		$("#originalprice").html("");
		$("#total_fee").val(0);
		$("#cash_fee").val(0);
	}
}


$(document).ready(function() {
	//选择服务物业
	$(".addressjs").click(function () {
		$(".addressjs").removeClass("typeClick");
		$(this).addClass("typeClick");
		strID = $(this).data("ID");
		$("#property_ID").val(strID);
		//alert($("#address").val());
	});
	
	$(".addressonejs").click(function () {
		$(".addressonejs").removeClass("typeClick");
		$('#period option[value=12]').attr('selected',true);
		$('#frequency option[value=1]').attr('selected',true);
		$(this).addClass("typeClick");
		strID = $(this).data("ID");
		area = $(this).data("f");
		tprice = area*200*12;
		cprice = tprice*discount/100;
		$("#property_ID").val(strID);
		$("#service").val('{"00":1}');
		$("#total_fee").val(tprice);
		$("#cash_fee").val(cprice);
		noticeDialog("服务价格计算公式：<br/>2元/平米x"+area+"平米x"+discount/10+"折x12个月="+parseInt(cprice*0.01)+ "元", 4000);
		if(cprice == tprice){
			$("#realityprice").html(parseInt(cprice/100) + "元");
		    $("#originalprice").html("");  
		}else{
			$("#realityprice").html(parseInt(cprice/100) + "元");
		    $("#originalprice").html(parseInt(tprice/100) + "元");  
		}
		 
	});
	
	$("#period").bind("change",function(){ 
		period = $(this).val();
		frequency = $("#frequency").val();
		tprice = area*200*frequency*period;
		cprice = tprice*discount/100;
		$("#total_fee").val(tprice);
		$("#cash_fee").val(cprice);
		noticeDialog("服务价格计算公式：<br/>2元/平米x"+area+"平米x"+discount/10+"折x"+period+"个月x"+frequency+"次="+parseInt(cprice*0.01)+ "元", 4000);
		if(cprice == tprice){
			$("#realityprice").html(parseInt(cprice/100) + "元");
			$("#originalprice").html("");  
		}else{
			$("#realityprice").html(parseInt(cprice/100) + "元");
			$("#originalprice").html(parseInt(tprice/100) + "元");  
		}
	}); 

    $("#frequency").bind("change",function(){ 
		period = $("#period").val();
		frequency = $(this).val();
		tprice = area*200*frequency*period;
		cprice = tprice*discount/100;
		$("#total_fee").val(tprice);
		$("#cash_fee").val(cprice);
		noticeDialog("服务价格计算公式：<br/>2元/平米x"+area+"平米x"+discount/10+"折x"+period+"个月x"+frequency+"次="+parseInt(cprice*0.01)+ "元", 4000);
		if(cprice == tprice){
			$("#realityprice").html(parseInt(cprice/100) + "元");
			$("#originalprice").html("");  
		}else{
			$("#realityprice").html(parseInt(cprice/100) + "元");
			$("#originalprice").html(parseInt(tprice/100) + "元");  
		}
	}); 

	
	$(".addressfrontjs").click(function () {
		$(".addressfrontjs").removeClass("typeClick");
		$(this).addClass("typeClick");
		strID = $(this).data("ID");
		area = $(this).data("f");
		tprice = area*500;
		cprice = tprice;
		//cprice = tprice*discount/100;
		$("#property_ID").val(strID);
		$("#service").val('{"00":1}');
		$("#total_fee").val(tprice);
		$("#cash_fee").val(cprice);
		if(cprice == tprice){
			$("#realityprice").html(parseInt(cprice/100) + "元");
		    $("#originalprice").html("");  
		}else{
			$("#realityprice").html(parseInt(cprice/100) + "元");
		    $("#originalprice").html(parseInt(tprice/100) + "元");  
		}
		 
	});
	
	$(".addressafterjs").click(function () {
		$(".addressafterjs").removeClass("typeClick");
		$(this).addClass("typeClick");
		strID = $(this).data("ID");
		area = $(this).data("f");
		tprice = area*400;
		cprice = tprice;
		//cprice = tprice*discount/100;
		$("#property_ID").val(strID);
		$("#service").val('{"00":1}');
		$("#total_fee").val(tprice);
		$("#cash_fee").val(cprice);
		if(cprice == tprice){
			$("#realityprice").html(parseInt(cprice/100) + "元");
		    $("#originalprice").html("");  
		}else{
			$("#realityprice").html(parseInt(cprice/100) + "元");
		    $("#originalprice").html(parseInt(tprice/100) + "元");  
		}
		 
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


function isupservice() { //数据检查之后的ajax提交事件
    //开始发送数据
   $.ajax({ //请求登录处理页
		url: "/wx-pages/wx_servorder_do.php", //处理页
		type: "POST",
		contentType:"application/x-www-form-urlencoded; charset=utf-8",
		dataType: "text",
		//传送请求数据
		data: $('#fm1').serialize(),
		success: function (strValue) { //登录成功后返回的数据
			
			//根据返回值进行状态显示
			strValue = $.trim(strValue);
			var strs = new Array(); //定义一数组 
			strs = strValue.split(":"); //字符分割 
			if (strs[0] == "True") {//注意是True,不是true
			    //noticeDialog("预定成功，后续会有专人与您联系！");
				$('#orderbt').attr("disabled",true); 
				//清空状态数据
			    realityAllDcPrice = 0;
                originalAllDcPrice = 0;
			    units = "";
			    $("#onup input").val(0);
			    $(".ipt").val("");
				//跳转到成功页面
				window.location.href='/wx-pages/wx_ordersuccess.php?order_ID='+strs[1];
			}
			else if(strs[0] == "余额不足"){
				
				if(confirm("余额不足，是否充值？"))
				{
					location.href="/wx-pages/wx_member.php";
				 }
				else
				{
				    location.href="/wx-pages/";
				}
				//noticeDialog("余额不足，请充值！");
				//$(".addressjs").html(strValue);
			}
			else{
				noticeDialog("预订不成功，请联系我们！"+strValue);
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

//第三方费用提交  <车管家，生活管家>
function submitTPFValidate() {
	
	var tpf = $("#third_part_fee").val();
	if (tpf == undefined || tpf == "" || tpf == null) {
		noticeDialog("请输入第三方费用");
		return;
	}else{
		if(!isPositiveNumber(tpf)){
			noticeDialog("输入数值不正确");
		    return;
			}
	}
	var order_ID = $("#order_ID").val();
	if (order_ID == undefined || order_ID == "" || order_ID == null) {
		noticeDialog("参数错误");
		return;
	}
	if(confirm("确认提交？")){
	   isupTPF();
	}
}


function isupTPF() { //数据检查之后的ajax提交事件
    //开始发送数据
   $.ajax({ //请求登录处理页
		url: "/wx-admin/ordersetfee_do.php", //处理页
		type: "POST",
		contentType:"application/x-www-form-urlencoded; charset=utf-8",
		dataType: "text",
		//传送请求数据
		data: $('#fm1').serialize(),
		success: function (strValue) { //登录成功后返回的数据
			
			//根据返回值进行状态显示
			strValue = $.trim(strValue);
			var strs = new Array(); //定义一数组 
			strs = strValue.split(":"); //字符分割 
			if (strs[0] == "True") {//注意是True,不是true
			    //noticeDialog("预定成功，后续会有专人与您联系！");
				//跳转到成功页面
				window.location.href='/wx-admin/orderdetail.php?order_ID='+strs[1];
			}else if(strs[0] == "余额不足"){
				noticeDialog("余额不足，请联系客户！");
			}
			else{
				noticeDialog("提交数据错误！"+strValue);
			}
		},
		error: function(data) {
			//alert("error:"+data.responseText);
			noticeDialog("内部错误，请联系我们！");
		}
	});
	return false;
};
//第三方费用提交  <车管家，生活管家> JS END