<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物业登记</title>
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="Ratchet">
<link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408">
<link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408">
<link rel="stylesheet" href="/wx-pages/css/index.css?v=20150408">
<script type='text/javascript' src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script>
<script type="text/javascript" src="/wp-includes/js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/wx-pages/script/main.js"></script>
<script type="text/javascript" src="/wx-pages/script/wx_main.js"></script>
<style type="text/css">
html, body {
	height: 100%;
}
</style>
<meta charset="utf-8">
</head>
<?php
include ('includes/dbconfig.php');
session_start();
if (!$_SESSION['openid']) {
	echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
}else{
	$openid = $_SESSION['openid'];
	$row = $db->row_select("wx_property", "type = 'house' and openid='" . $openid . "'", 0, "*", "property_ID");
	$strtemp = "";
	foreach ($row as $key => $value) {
		$address = $value['e'];
		if(mb_strlen($address,'UTF8')>13){
		$address = mb_substr($address, 0, 6, 'utf-8') . "..." . mb_substr($address, -7, 7, 'utf-8');
		}
		$strtemp .="<li class='table-view-cell' id='".$value['property_ID']."'>";
		
		$strtemp .= "<i class='ico-map-marker'></i>";
		$strtemp .= "<p class='ipt propertylist'><a href='wx_propertydetail.php?property_ID=".$value['property_ID']."'>". $address ."</a></p>";
		//$strtemp .= "<a class='ipt'  style='cursor:pointer' id='sp_del' data-id='" . $value['property_ID'] . "'>删除</a>";
		$strtemp .= "</li>";
    }
}
?>
<body>
<form name="fm1" id="fm1" >
  <input name="openid" type="hidden" value="<?php echo $openid ;?>">
  <input name="type" id="type" type="hidden" value="house">
  <input name="uptype" id="uptype" type="hidden" value="new">
  <input name="g" id="g" type="hidden" value=""><!--图片信息-->
  <!--content begin-->
  <div class="content content2">
    <div class="table-mod">
      <h4></h4>
      <h4>*您已登记的物业</h4>
      <ul class="table-view card">
        <?php echo $strtemp;?>
      </ul>
    </div>
    <!--table-view end-->
    
    <div class="table-mod">
      <h4>新增物业</h4>
      <ul class="table-view card">
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input type="text" class="ipt" name="a" id="a" placeholder="房产所有人（须与房产证一致）"/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="b" id="b" placeholder="联系人（日常具体事物联系）"/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="c" id="c" placeholder="固定电话（如：01088632548） "/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="d" id="d" placeholder="移动电话 "/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="e" id="e" placeholder="房产地址（须与房产证一致）"/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="f" id="f" placeholder="房产面积（单位：平米，范围：10-2000） "/>
        </li>
        <li class="table-view-cell" id="coupons_view"> <i class="ico-tags"></i>
          <select name="couponid" id="couponid">
            <option value="0">房屋户型</option>
            <option value="一居室（1卫）">一居室（1卫）</option>
            <option value="二居室（1卫）">二居室（1卫）</option>
            <option value="大二居（2卫）">大二居（2卫）</option>
            <option value="三居室（2卫）">三居室（2卫）</option>
            <option value="四居室（3卫）">四居室（3卫）</option>
            <option value="200平米以上">200平米以上</option>
          </select>
        </li>
        <li class="table-view-cell" id="coupons_view">
          <p class="form-row form-row-wide">
          <div class="imagup">
            <p><span class="required">*</span>说明：须为gif/jpg格式，不超过2M。</p>
            <div class="imagup_btn1"> &nbsp;<span id="weixin">选择房产证图片</span>
            </div>
            <div class="imagup_btn1"> &nbsp;<span id="upload">确认上传</span>
            </div>
            <div style="height:2px"></div>
            <div class="showimg"><img src="" id="showimges" style="width:280px"></div>
          </div>
     </li>
      </ul>
      <ul class="table-view card" style="border:none;">
        <div class="pull-right" id="clsShow">
          <button class="btn btn-positive btn-positive2" type="button" style="background-color:#825623; border-color:#825623" id="property_updata" onclick="javascript:submitValidate_p();">确认添加</button>
        </div>
      </ul>
    </div>
  </div>
  <!--content end-->
</form>
<!--bar-tab begin -->
<div class="bar bar-footer bar-tab"> <a class="tab-item " href="/wx-pages/" data-ignore="push"> <span class="tab-label">微网站</span> </a> <a class="tab-item" href="/wx-pages/wx_orderlist.php" data-ignore="push"> <span class="tab-label">我的订单</span> </a> <a class="tab-item active" data-ignore="push" href="/wx-pages/mypage.php"> <span class="tab-label">个人中心</span> </a> </div>
<?php
/**
	请开启PHP的扩展
	extension=php_curl.dll
	extension=php_openssl.dll
	**/
	//设置报错级别，忽略警告，设置字符
	error_reporting(E_ALL || ~E_NOTICE);
	require_once "includes/jssdk.php";
	//配置JSSDK参数
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
$(document).ready(function(){
  wx.config({
    debug: false, //调试阶段建议开启
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
           /*
            * 所有要调用的 API 都要加到这个列表中
            * 这里以图像接口为例
            */
          "chooseImage",
          "previewImage",
          "uploadImage",
          "downloadImage"
    ]
  });
  var btn = document.getElementById('weixin');
  //定义images用来保存选择的本地图片ID，和上传后的服务器图片ID
  var images = {
      localId: [],
      serverId: []
  };
  wx.ready(function () {
    // 在这里调用 API
    btn.onclick = function(){
        wx.chooseImage ({
			count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['camera'], // 可以指定来源是相册（album）还是相机（camera），默认二者都有
            success : function(res){
                images.localId = res.localIds;  //保存到images
                document.getElementById('showimges').src=images.localId;
                // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            }
        });
    }
    document.getElementById('upload').onclick = function(){
        var i = 0, len = images.localId.length;
        function wxUpload(){
            wx.uploadImage({
                localId: images.localId[i], // 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    i++;
                    //将上传成功后的serverId保存到serverid
                    images.serverId.push(res.serverId);
                    //(serverId 即 media_id,公众号此后可根据该media_id来获取多媒体)
					//将上传的图片通过AJAX远程提交给php下载到本地服务器
                    $.get("/wx-pages/wx_property_do.php", {act:"newimg", media_id: res.serverId, accesstoken: "<?php echo $signPackage["accesstoken"];?>" ,time: "2pm" },
                    function(data){
                        if(data=="error"){
							alert("上传错误，请重试！");
						}else{
						    $("#g").val(data);
							$("#upload").html("上传成功");
						}
                    });                 

                    if(i < len){
                        wxUpload();
                    }  
                }
            });
        }      
        wxUpload(); 
    }
    /*document.getElementById('getServices').onclick = function(){
         alert(images.serverId);
         //images.serverId   不能直接通过src读取,images.localId才可以直接赋值给img src
         var a=document.getElementById ("a");
            a.innerHTML = images.serverId;
    }*/
  });

});
</script>
<!--<button id="getServices">获取已上传的图片</button>-->
<!--<span id="a"></span>读取serverId-->
</body>
</html>