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
$_SESSION['openid'] = "oN8WPs8kWI3zaX8ToMMF5brBjdGE";
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
  <input name="g" id="g" type="hidden" value="">
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
            <p><span class="required">*</span>房产证图片。说明：须为gif/jpg格式，不超过2M。</p>
            <div class="imagup_btn1"> &nbsp;<span>添加服务前效果图</span>
              <input id="fileupload1" type="file" name="mypic1" value="上传效果图">
            </div>
            <div class="imagup_progress"> <span class="imagup_bar"></span><span class="imagup_percent">0%</span > </div>
            <div class="imagup_files">
            </div>
            <div id="showimges" class="showimg"></div>
          </div>
     </li>
      </ul>
      <ul class="table-view card">
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
</body>
</html>