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
if ($_SESSION['user_level'] <7) {
	//PC端后台
	echo "<script>window.location.href='/wx-admin/islogin.php';</script>";
}else if(isset($_GET['property_ID'])){
	$openid = $_SESSION['openid'];
	$property_ID = $_GET['property_ID'];
	$row = $db->row_select("wx_property", "type = 'house' and property_ID='" . $property_ID . "'", 1, "*", "property_ID");
	$strtemp = "";
	if(count($row)>0){
		foreach ($row as $key => $value) {
			$property_ID = $value['property_ID']; 
			$approved = $value['approved']; 
			$a = $value['a'];
			$b = $value['b'];
			$c = $value['c'];
			$d = $value['d'];
			$e = $value['e'];
			$f = $value['f'];
			$g = $value['g'];
			$h = $value['h'];
		}
		if($approved == 1) $state = "已认证";
		if($approved == 0) $state = "待认证";
	}else{
		 echo"<script>history.go(-1);</script>"; 	
	}
}
?>
<body>
<!--banner begin-->
<div class="banner">
    <div style="text-align:center;"> <img style="margin:0 auto;" src="/wx-pages/images/none.png" width="100%" alt="" /> </div>
    <h3 style="text-align:center;color:#E6550F">目前状态：<?php echo $state;?></h3>
  </div>
<!--banner end-->
<form name="fm1" id="fm1" >
  <input name="openid" type="hidden" value="<?php echo $openid ;?>">
  <input name="property_ID" type="hidden" value="<?php echo $property_ID ;?>">
  <input name="type" id="type" type="hidden" value="house">
  <input name="uptype" id="uptype" type="hidden" value="update">
  <input name="g" id="g" type="hidden" value="<?php echo $g;?>">
  <!--content begin-->
  <div class="content">
    
    <div class="table-mod">
      
      <ul class="table-view card">
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input type="text" class="ipt" name="a" id="a" value="<?php echo $a;?>" placeholder="房产所有人（须与房产证一致）"/>          
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="b" id="b" value="<?php echo $b;?>" placeholder="联系人（日常具体事物联系）"/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="c" id="c" value="<?php echo $c;?>" placeholder="固定电话（如：01088632548） "/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="d" id="d" value="<?php echo $d;?>" placeholder="移动电话 "/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="e" id="e" value="<?php echo $e;?>" placeholder="房产地址（须与房产证一致）"/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
          <input class="ipt" type="text" name="f" id="f" value="<?php echo $f;?>" placeholder="房产面积（单位：平米，范围：10-2000） "/>
        </li>
        <li class="table-view-cell" id="coupons_view"> <i class="ico-tags"></i>
          <select name="couponid" id="couponid">
            <option value="0">房屋户型</option>
            <?php 
			if($h== "一居室（1卫）") $s1="selected";
			if($h== "二居室（1卫）") $s2="selected";
			if($h== "大二居（2卫）") $s3="selected";
			if($h== "三居室（2卫）") $s4="selected";
			if($h== "四居室（3卫）") $s5="selected";
			if($h== "200平米以上") $s6="selected";
			?>
            <option value="一居室（1卫）" <?php echo $s1;?>>一居室（1卫）</option>
            <option value="二居室（1卫）" <?php echo $s2;?>>二居室（1卫）</option>
            <option value="大二居（2卫）" <?php echo $s3;?>>大二居（2卫）</option>
            <option value="三居室（2卫）" <?php echo $s4;?>>三居室（2卫）</option>
            <option value="四居室（3卫）" <?php echo $s5;?>>四居室（3卫）</option>
            <option value="200平米以上" <?php echo $s6;?>>200平米以上</option>
          </select>
        </li>
        <li class="table-view-cell" id="coupons_view">
        <?php if(empty($g)){?>
        <p class="form-row form-row-wide">
          <div class="imagup">
            <p><span class="required">*尚未添加房产证图片。</span><br/>说明：须为gif/jpg格式，不超过2M。</p>
            <div class="imagup_btn1"> &nbsp;<span>添加房产证图片</span>
              <input id="fileupload1" type="file" name="mypic1" value="上传效果图">
            </div>
            <div class="imagup_progress"> <span class="imagup_bar"></span><span class="imagup_percent">0%</span > </div>
            <div class="imagup_files" style="display:none;">
            </div>
            <div style="height:2px"></div>
            <div id="showimges" class="showimg">
            </div>
          </div>
        <?php }else {?>
          <p class="form-row form-row-wide">
          <div class="imagup">
            <p><span class="required">*</span>说明：须为gif/jpg格式，不超过2M。</p>
            <div class="imagup_btn1"> &nbsp;<span>修改房产证图片</span>
              <input id="fileupload1" type="file" name="mypic1" value="上传效果图">
            </div>
            <div class="imagup_progress"> <span class="imagup_bar"></span><span class="imagup_percent">0%</span > </div>
            <div class="imagup_files" style="display:none;">
            </div>
            <div style="height:2px"></div>
            <div id="showimges" class="showimg">
            <img src="/wx-pages/uploads/<?php echo $g;?>" width="100%">
            </div>
          </div>
          <?php }?>
     </li>
      </ul>
      <ul class="table-view card" style="border:none">
        <div class="pull-right" id="clsShow">
          <button class="btn btn-positive btn-positive2" type="button" style="background-color:#825623; border-color:#825623" onClick="javascript:location.href='/wx-admin/propertyimg.php?property_ID=<?php echo $property_ID;?>'" >现状图库</button> &nbsp;&nbsp;&nbsp;&nbsp;
          <?php
          if($approved==0){
		  ?>
          <button class="btn btn-positive btn-positive2" type="button" style="background-color:#825623; border-color:#825623" id="property_updata" onclick="javascript:submitApproved_p(<?php echo $property_ID;?>,1);">认证通过</button>
          <?php } 
		  else if($approved==1){
		  ?>
          <button class="btn btn-positive btn-positive2" type="button" style="background-color:#825623; border-color:#825623" id="property_updata" onclick="javascript:submitApproved_p(<?php echo $property_ID;?>,0);">取消认证</button>
          <?php }?>
        </div>
      </ul>
    </div>
    <div style="height:30px;"></div>
  </div>
  <!--content end-->
</form>
</body>
</html>