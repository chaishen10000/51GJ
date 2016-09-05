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
if (!$_SESSION['openid']||$_SESSION['user_level'] <7 ) {
	echo "<script>window.location.href='/wx-admin/islogin.php';</script>";
}else{
	$openid = $_SESSION['openid'];
	if(isset($_GET['approved'])){
	  $approved = $_GET['approved'];
	  $sql = "type = 'house' and approved=".$approved;
	}else{
	  $approved = 2;
	  $sql = "type = 'house'";
	}
	if($approved ==0){
	$active0 = "active";
	}
	elseif($approved ==1){
		$active1 = "active";
	}else{
		$active2 = "active";
	}
	$row = $db->row_select("wx_property", $sql, 0, "e,property_ID,approved", "property_ID");
	$strtemp = "";
	$i = 0;
	foreach ($row as $key => $value) {
		$i +=1;
		$address = $value['e'];
		$approved = $value['approved'];
		if($approved == 1) $state = "已审核";
	    if($approved == 0) $state = "待审核";
		$strtemp .="<li class='table-view-cell' style='padding-right:15px' id='".$value['property_ID']."'>";
		$strtemp .= "<p class='ipt propertylist'>".$i.".<a href='propertydetail.php?property_ID=".$value['property_ID']."'>(".$state.")". $address ."</a></p>";
		//$strtemp .= "<a class='ipt'  style='cursor:pointer' id='sp_del' data-id='" . $value['property_ID'] . "'>删除</a>";
		$strtemp .= "</li>";
    }
}
?>
<body>
<!--banner begin--> 
    <div class="banner"> 
      <div style="text-align:center;"> 
       <img style="margin:0 auto;" src="/wx-pages/images/none.png" width="100%" alt="" /> 
      </div> 
      <h3 style="text-align:center;color:#E6550F">*已登记物业列表</h3> 
    </div> 
    <!--banner end--> 
  <!--content begin-->
  <div class="content content2">
    <div class="table-mod">
        <?php echo $strtemp;?>
    </div>
    <!--table-view end-->
<!--bar-tab begin -->
<div class="bar bar-footer bar-tab" > <a class="tab-item <?php echo $active2;?>" href="?" data-ignore="push"> <span class="tab-label">全部</span> </a> <a class="tab-item <?php echo $active1;?>" href="?approved=1" data-ignore="push"> <span class="tab-label">已审核</span> </a> <a class="tab-item <?php echo $active0;?>" data-ignore="push" href="?approved=0"> <span class="tab-label">待审核</span> </a> </div>
</body>
</html>