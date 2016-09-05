<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <title>物业现状图库</title> 
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <meta name="apple-mobile-web-app-title" content="Ratchet" /> 
  <link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/index.css?v=20150408">
  <script type='text/javascript' src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script>
  <script type="text/javascript" src="/wp-includes/js/jquery/jquery.form.js"></script>
  <script type='text/javascript' src='/wx-admin/script/admin_property.js'></script>
  <style type="text/css"> 
	.table_list{overflow:hidden;zoom:1;} 
	.table_list li{ width:50%;float:left;} 
  </style> 
  <meta charset="utf-8" /> 
 </head> 
 <body> 
<?php
include ('includes/dbconfig.php');
include ('includes/wx_message_class.php');
session_start();
if (!$_SESSION['openid']||$_SESSION['user_level'] <7) {
    echo "</script>window.location.href='/wx-admin/islogin.php';</script>";
} else {
    $property_ID = $_GET["property_ID"];
    $openid = $_SESSION['openid'];
    $row = $db->row_select("wx_property", "property_ID=" . $property_ID, 1, "*", "property_ID");
    foreach ($row as $key => $value) {
        $approved = $value['approved'];
        $images1 = $value['images1'];
        $images2 = $value['images2'];
		$images3 = $value['images3'];
		$images4 = $value['images4'];
    }
	if($approved == 1) $state = "已认证";
	if($approved == 0) $state = "待认证";
}
?>
<!--banner begin--> 
    <div class="banner"> 
      <div style="text-align:center;"> 
       <img style="margin:0 auto;" src="/wx-pages/images/none.png" width="100%" alt="" /> 
      </div> 
      <h3 style="text-align:center;color:#E6550F">目前状态：<?php echo $state;?></h3> 
    </div> 
    <!--banner end--> 
    <ul class="table-view table-view2" id="onup"> 
    <input name="property_ID" id="property_ID" type="hidden" value="<?php echo $property_ID;?>">
<li class="table-view-cell" id="coupons_view">
          <p class="form-row form-row-wide">
          <div class="imagup">
            <p><span class="required">*</span>说明：须为gif/jpg格式，不超过2M。</p>
            <div class="imagup_btn1"> &nbsp;<span>建筑</span>
              <input id="fileupload1" type="file" name="mypic1" value="上传效果图">
            </div>
            <div class="imagup_btn2"> &nbsp;<span>家具</span>
              <input id="fileupload2" type="file" name="mypic2" value="上传效果图">
            </div>
            <div class="imagup_btn3"> &nbsp;<span>家电</span>
              <input id="fileupload3" type="file" name="mypic3" value="上传效果图">
            </div>
            <div class="imagup_btn4"> &nbsp;<span>其他</span>
              <input id="fileupload4" type="file" name="mypic4" value="上传效果图">
            </div>
            <div class="imagup_progress"> <span class="imagup_bar"></span><span class="imagup_percent">0%</span > </div>
            <div class="imagup_files">
            </div>
            <div id="showimges"></div>
            <div style="height:5px"></div>
            <?php 
			    if(!empty($images1)){
				$imagearr = explode(";",$images1);
				echo "<h4>建筑现状登记</h4>";
				foreach($imagearr as $u){
			?>
            <div class="showimg" id="show<?php echo substr($u,0,strlen($u)-4);?>"><img src='/wx-admin/uploads/<?php echo $u?>' width='100%'> 
            <div class="imagup_delimg" data-fag="images1" data-id="<?php echo $property_ID?>" rel="<?php echo $u?>">删除</div>
            </div>
            <div style="height:2px"></div>
            <?php }}
			if(!empty($images2)){
				$imagearr = explode(";",$images2);
				echo '<h4>家具现状登记</h4>';
				foreach($imagearr as $u){
			?>
            <div class="showimg" id="show<?php echo substr($u,0,strlen($u)-4);?>"><img src='/wx-admin/uploads/<?php echo $u?>' width='100%'>
            <div class="imagup_delimg" data-fag="images2" data-id="<?php echo $property_ID?>" rel="<?php echo $u?>">删除</div>
            </div>
            <div style="height:2px"></div>
            <?php }}
			if(!empty($images3)){
				$imagearr = explode(";",$images3);
				echo '<h4>家电现状登记</h4>';
				foreach($imagearr as $u){
			?>
            <div class="showimg" id="show<?php echo substr($u,0,strlen($u)-4);?>"><img src='/wx-admin/uploads/<?php echo $u?>' width='100%'>
            <div class="imagup_delimg" data-fag="images3" data-id="<?php echo $property_ID?>" rel="<?php echo $u?>">删除</div>
            </div>
            <div style="height:2px"></div>
            <?php }}
			if(!empty($images4)){
				$imagearr = explode(";",$images4);
				echo '<h4>家具现状登记</h4>';
				foreach($imagearr as $u){
			?>
            <div class="showimg" id="show<?php echo substr($u,0,strlen($u)-4);?>"><img src='/wx-admin/uploads/<?php echo $u?>' width='100%'>
            <div class="imagup_delimg" data-fag="images4" data-id="<?php echo $property_ID?>" rel="<?php echo $u?>">删除</div>
            </div>
            <div style="height:2px"></div>
            <?php }}
			 if(empty($images1)&& empty($images2)&& empty($images3)&& empty($images4)){?>
            <div id="showimg"></div>
            <?php }?>
          </div>
          </p>
     </li>
    </ul> 
</body>
</html>