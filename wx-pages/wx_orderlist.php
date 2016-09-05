<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的订单</title>
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="apple-mobile-web-app-title" content="Ratchet" />
<link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" />
<link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" />
<script src="/wx-pages/script/jquery-1.11.1.min.js" type="text/javascript"></script>
<meta charset="utf-8" />
<style>
.step-no11, .step-no12, .step-no13, .step-no21, .step-no22, .step-no23, .step-no31, .step-no32, .step-no33, .step-no41, .step-no42, .step-no43 {
	height: 17px;
}
.step-no11 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -17px rgba(0,0,0,0);
}
.step-no12 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -51px rgba(0,0,0,0);
}
.step-no13 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -68px rgba(0,0,0,0);
}
.step-no21 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -102px rgba(0,0,0,0);
}
.step-no22 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% 0px rgba(0,0,0,0);
}
.step-no23 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -68px rgba(0,0,0,0);
}
.step-no31 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -102px rgba(0,0,0,0);
}
.step-no32 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -85px rgba(0,0,0,0);
}
.step-no33 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -34px rgba(0,0,0,0);
}
.step-no41 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -102px rgba(0,0,0,0);
}
.step-no42 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -85px rgba(0,0,0,0);
}
.step-no43 {
	background: url("/wx-pages/images/orderstate.png") no-repeat scroll 50% -123.5px rgba(0,0,0,0);
}
.card .table-view-cell {
	padding: 15px 15px 15px 15px;
}
</style>
</head>
<body>
<?php 
include ('includes/dbconfig.php');
session_start();
if (!$_SESSION['openid']) {
	echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
}else{
	//任务列表条件
	$getstate = (int)$_GET['state'];
	$sql = "";
	if($getstate == 1) $sql = "state='已提交' and ";
	if($getstate == 2) $sql = "state='服务中' and ";
	if($getstate == 3) $sql = "state='已服务' and ";
	//if($getstate == 4) $sql = "state='已完成' and ";
	$row = $db->row_select('wx_order', $sql.' openid=\'' . $_SESSION['openid'] . '\'', 0, '*', 'order_ID');
	$strtemp = "";
	if(count($row)==0){
		$strtemp = "<br/><br/><br/><h4 style='color:#CCC'>您还没有订单！</h4>";
	}else{
	foreach ($row as $key => $value) {
		$order_ID = $value['order_ID'];
		$type = $value['type'];
		$time_up = $value['time_up'];
		$state = $value['state'];
		$time_serv = $value['time_serv'];
		$cash_fee = (int)$value['cash_fee'];
		$cash_fee = $cash_fee/100;
		$service_detail = $value['service_detail'];
		if($state=="已取消") $scss = "0";
        if($state=="已提交") $scss = "1";
		if($state=="服务中") $scss = "2";
		if($state=="已服务") $scss = "3";
		if($state=="已完成") $scss = "4";
		if($type=="房管家") {
			if(empty($service_detail)) $service_detail = "12:1";
			$s_detail = explode(":",$service_detail);
			$s_detailstr =$s_detail[0]."个月,".$s_detail[1]."次/月";
		}
		$st = substr($servtime,0,4)."-".substr($servtime,4,2)."-".substr($servtime,6,2);
		
		$strtemp.= "<ul class='table-view card'><li class='table-view-cell'><table cellpadding='0' cellspacing='0' align='center' width='100%'><tr height='30' align='center'><td ><h4>";
		$strtemp.= "<a href='/wx-pages/wx_orderdetail.php?order_ID=".$order_ID."' data-ignore='push'> ";
		$strtemp.= $type;
		$strtemp.= "</a></h4></td><td align='right' colspan='2' >";
		if($state=="已取消"){
		   $strtemp.= "(".$state.")";
		}else if($type=="房管家") {
		   $strtemp.= $s_detailstr;
		}
		$strtemp.= "</td></tr><tr height='30' align='center'><td align='left' colspan='2'>";
		$strtemp.= $time_serv;
		$strtemp.= "</td><td >";
		$strtemp.= $cash_fee."元";
		$strtemp.= "</td></tr><tr><td class='step-no".$scss."1' width='33%'></td><td class='step-no".$scss."2' width='33%'></td><td class='step-no".$scss."3' width='33%'></td></tr>";
		$strtemp.= "<tr style='font-size:14px'><td align='center' height='20' width='33%'>确认</td><td align='center' width='33%'>服务</td><td align='center' width='33%'>完成</td></tr><tr style='font-size:10px'><td align='center' height='20' width='33%'>";
		$strtemp.= date ("Y.m.d H:i" ,(int)$time_up); 
		$strtemp.= "</td><td align='center' width='33%'>";
		//$strtemp.= date ("Y.m.d H:i" ,(int)$time_up); 
		$strtemp.= "</td><td align='center' width='33%'>";
		$strtemp.= $time_serv;
		$strtemp.= "</td></tr></table></li></ul>";
    }
	}
}
//echo $paystate;
?>
<div class="table-mod">

    <?php echo $strtemp;?>

</div>
<div style="width:100%; height:50px"></div>
<!--bar-tab begin -->
	<div class="bar bar-footer bar-tab">
        <a class="tab-item" href="/wx-pages/" data-ignore="push">
	        <span class="tab-label">首页</span>
	    </a>
	    <a class="tab-item <?php if($getstate==1) echo 'active'?>" href="?state=1" data-ignore="push">
	        <span class="tab-label">待服务</span>
	    </a>
	    <a class="tab-item <?php if($getstate==2) echo 'active'?>" href="?state=2" data-ignore="push">
	        <span class="tab-label">服务中</span>
	    </a>
	    <a class="tab-item <?php if($getstate==3) echo 'active'?>" href="?state=3" data-ignore="push" >
	        <span class="tab-label">已服务</span>
	    </a>
        
	</div>
    <!--bar-tab end-->
</body>
</html>