<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单详情</title>
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="apple-mobile-web-app-title" content="Ratchet" />
<link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" />
<link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" />
<link rel="stylesheet" href="/wx-pages/css/starscore.css" />
<style type="text/css">
.table_list {
	overflow: hidden;
	zoom: 1;
}
.table_list li {
	width: 50%;
	float: left;
}
</style>
<meta charset="utf-8" />
</head>
<body>
<?php
include ('includes/dbconfig.php');
session_start();
if (!$_SESSION['openid']) {
    echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
} else {
    $order_ID = $_GET["order_ID"];
    $openid = $_SESSION['openid'];
    $row = $db->row_select("wx_order", "order_ID=" . $order_ID, 1, "*", "order_ID");
    foreach ($row as $key => $value) {
        $state = $value['state'];
        $type = $value['type'];
        $service = $value['service'];
        $time_serv = $value['time_serv'];
        $property_ID = $value['property_ID'];
        $cash_fee = (int)$value['cash_fee'];
		$cash_fee1 = $cash_fee/100;
		$total_fee = (int)$value['total_fee'];
		$total_fee1 = $total_fee/100;
		$customcheck = $value['customcheck'];
		$fimages = $value['fimages'];
		$aimages = $value['aimages'];
		$service_detail = $value['service_detail'];
		$service_progress = $value['service_progress'];
		$remarks = $value['remarks'];
    }
	if($type=="房管家" &&!empty($service_detail)) {
			$s_detail = explode(":",$service_detail);
			$s_detailstr ="（".$s_detail[0]."个月,".$s_detail[1]."次/月）";
			$s_detailfrq = (int)$s_detail[0]*(int)$s_detail[1];
	}
    if ($_GET["action"] == "cancel") {
        $urow1 = array();
        $urow1['state'] = '已取消';
        //款项退回
        $urow2 = array();
        $urow2['user_cash'] = 'user_cash+' . $cash_fee;
        //$urow2['total_consumer'] = 'total_consumer-' . $cash_fee;
        $upstate = servicecancel($db, $urow1, $urow2, $openid, $order_ID);
		if($upstate == "True") echo "<script>window.location.href='wx_orderdetail.php?order_ID=$order_ID';</script>"; 
    }
    if ($_GET["action"] == "ok") {
        $urow = array();
        $urow["customcheck"] = "ok";
        $upstate = serviceok($db, $urow, $order_ID);
		if($upstate == "True") echo "<script>window.location.href='wx_orderdetail.php?order_ID=$order_ID';</script>"; 
    } else {
        $row = $db->row_select("wx_property", "property_ID=" . $property_ID, 1, "e", "property_ID");
        foreach ($row as $key => $value) {
            $address = $value['e'];
        }
        $obj = json_decode($service);
        $sqlstr = "";
        //常规清洁
        if (isset($obj->{'11'})) $sqlstr.= getserviceitem($db, '11') . "x" . $obj->{'11'} . " ";
        if (isset($obj->{'12'})) $sqlstr.= getserviceitem($db, '12') . "x" . $obj->{'12'} . " ";
        if (isset($obj->{'13'})) $sqlstr.= getserviceitem($db, '13') . "x" . $obj->{'13'} . " ";
        if (isset($obj->{'14'})) $sqlstr.= getserviceitem($db, '14') . "x" . $obj->{'14'} . " ";
        //深度清洁
        if (isset($obj->{'21'})) $sqlstr.= getserviceitem($db, '21') . "x" . $obj->{'21'} . " ";
        if (isset($obj->{'22'})) $sqlstr.= getserviceitem($db, '22') . "x" . $obj->{'22'} . " ";
        if (isset($obj->{'23'})) $sqlstr.= getserviceitem($db, '23') . "x" . $obj->{'23'} . " ";
        if (isset($obj->{'24'})) $sqlstr.= getserviceitem($db, '24') . "x" . $obj->{'24'} . " ";
        //除尘除螨
        if (isset($obj->{'31'})) $sqlstr.= getserviceitem($db, '31') . "x" . $obj->{'31'} . " ";
        if (isset($obj->{'32'})) $sqlstr.= getserviceitem($db, '32') . "x" . $obj->{'32'} . " ";
        if (isset($obj->{'33'})) $sqlstr.= getserviceitem($db, '33') . "x" . $obj->{'33'} . " ";
        if (isset($obj->{'34'})) $sqlstr.= getserviceitem($db, '34') . "x" . $obj->{'34'} . " ";
        //家电清洁
        if (isset($obj->{'41'})) $sqlstr.= getserviceitem($db, '41') . "x" . $obj->{'41'} . " ";
        if (isset($obj->{'42'})) $sqlstr.= getserviceitem($db, '42') . "x" . $obj->{'42'} . " ";
        if (isset($obj->{'43'})) $sqlstr.= getserviceitem($db, '43') . "x" . $obj->{'43'} . " ";
        if (isset($obj->{'44'})) $sqlstr.= getserviceitem($db, '44') . "x" . $obj->{'44'} . " ";
        if (isset($obj->{'45'})) $sqlstr.= getserviceitem($db, '45') . "x" . $obj->{'45'} . " ";
    }
	if($type=="房管家") $sqlstr = "房管家整体清洁养护".$s_detailstr;
	if($type=="住前打理") $sqlstr = "住前整体清洁、整理";
	if($type=="住后整理") $sqlstr = "住后整体清洁、整理";
	//车管家
	if($type=="车管家") {
		$s_detailfrq = 1;
		$service_progress = 1;
	}
	if(isset($obj->{'50'})){
	   $sqlstr .= getserviceitem($db,$obj->{'50'});
	   $address = $remarks;
	   }
	if(isset($obj->{'60'})){
	   $sqlstr .= getserviceitem($db,$obj->{'60'});
	   $address = $remarks;
	   }
	if(isset($obj->{'70'})){
	   $sqlstr .= getserviceitem($db,$obj->{'70'});
	   $address = $remarks;
	   }
	if(isset($obj->{'80'})){
	   $sqlstr .= ",".getserviceitem($db,$obj->{'80'});
	   $address = $remarks;
	   }
	if(isset($obj->{'90'})){
	   $sqlstr .= ",".getserviceitem($db,$obj->{'90'});
	   $address = $remarks;
	   }
}
function getserviceitem($db, $class) {
    $row = $db->row_select("wx_service", "class='" . $class . "'", 1, "itemname", "service_ID");
    foreach ($row as $key => $value) {
        $itemname = $value['itemname'];
    }
    return $itemname;
}
function servicecancel($db, $urow1, $urow2, $openid, $order_ID) {
    $row1 = $db->row_update("wx_order", $urow1, "order_ID=" . $order_ID);
    $row2 = $db->row_update_int("wp_users", $urow2, "openid='" . $openid . "'");
    //记录日志
    if ($row1 && $row2) {
        return "True"; 
    }
}
function serviceok($db, $urow, $order_ID) {
    $row = $db->row_update("wx_order", $urow, "order_ID=" . $order_ID);
    //记录日志
    if ($row) {
        return "True"; 
    }
}
?>
<!--banner begin-->
<div class="banner">
  <div style="text-align:center;"> <img style="margin:0 auto;" src="/wx-pages/images/none.png" width="100%" alt="" /> </div>
  <h3 style="text-align:center;color:#E6550F">目前状态：<?php echo $state;?></h3>
</div>
<!--banner end-->
<ul class="table-view table-view2" id="onup">
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 项目 </div>
    <div class="table-cell" style="text-align:left; "> <?php echo $type;?> </div>
  </li>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 内容 </div>
    <div class="table-cell" style="text-align:left; "> <?php echo $sqlstr;?> </div>
  </li>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 时间 </div>
    <div class="table-cell" style="text-align:left; "> <?php echo $time_serv;?> </div>
  </li>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 地址 </div>
    <div class="table-cell" style="text-align:left; "> <?php echo $address;?> </div>
  </li>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 价格 </div>
    <div class="table-cell" style="text-align:left; "> <?php echo $cash_fee1;?>元
      <?php if($cash_fee1<$total_fee1){?>
      （<span style="text-decoration:line-through"><?php echo $total_fee1;?></span>元）
      <?php }?>
      <?php if($type=="车管家"){?>
      （服务费）
      <?php }?>
    </div>
  </li>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 备注 </div>
    <div class="table-cell" style="text-align:left; ">
      <?php if($type=="车管家"){?>
      <span style="color:#E36406; font-size:14px">第三方费用,将由专人在服务前与您核实确认后垫付，服务完成后按实际发生金额结算。</span>
      <?php }?>
    </div>
  </li>
  <?php if($state == "已完成" || $state == "已服务" || $state == "服务中"){?>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="table-cell" style="text-align:center; font-weight:700;"> 进度 </div>
    <div class="table-cell" style="text-align:left;color:#F63"> 共<?php echo $s_detailfrq;?>次服务，已完成<?php echo $service_progress;?>次。 </div>
  </li>
  <?php }?>
  <?php if($state == "已完成" || $state == "已服务" ){?>
  <li class="table-view-cell" id="coupons_view">
    <?php 
			if(!empty($fimages)){
			$imagearr = explode(";",$fimages);
			echo "<h4 style='color:#F30;padding-top:5px'>+服务前效果</h4>";
			foreach($imagearr as $u){
	    ?>
    <div class="showimg" id="show<?php echo substr($u,0,strlen($u)-4);?>"><img src='/wx-admin/uploads/<?php echo $u?>' width='100%'></div>
    <div style="height:2px"></div>
    <?php }}
			if(!empty($aimages)){
				$imagearr = explode(";",$aimages);
				echo "<h4 style='color:#F30;padding-top:5px'>+服务后效果</h4>";
				foreach($imagearr as $u){
			?>
    <div class="showimg" id="show<?php echo substr($u,0,strlen($u)-4);?>"><img src='/wx-admin/uploads/<?php echo $u?>' width='100%'></div>
    <div style="height:2px"></div>
    <?php }}
			 if(empty($fimages)&& empty($aimages)){?>
    <div id="showimg"></div>
    <?php }?>
    </div>
  </li>
  <?php }?>
  <?php if($state == "已完成" || $state == "已服务"){?>
  <li class="table-view-cell table-disabled" id="numtable0">
    <div class="content">
      <div id="starttwo" class="block clearfix">
        <div  class="star_score"></div>
        <p style="float:left;">评分：<span class="fenshu"></span> 分</p>
      </div>
      <script type="text/javascript" src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script> 
      <script type="text/javascript" src="/wx-pages/script/startScore.js"></script> 
      <script>
       scoreFun($("#startone"))
       scoreFun($("#starttwo"),{
           fen_d:22,//每一个a的宽度
           ScoreGrade:5//a的个数 10或者
         })
      </script> 
    </div>
  </li>
  <?php }?>
</ul>
<div class="table-mod">
  <ul class="table-view card table_list">
    <li>
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;background-color:#E36406; border-color:#E36406" type="button" onClick="javascript:location.href='tel:01059476853'">联系客服</button>
    </li>
    <?php if($state == "已提交") {?>
    <li>
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;background-color:#CCC;border-color:#CCC" type="button" onClick="javascript:cancelorder();">取消订单</button>
    </li>
    <?php }else if($state == "已取消" ||$state == "服务中" || $state == "已服务"){?>
    <li>
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;" type="button" onClick="javascript:location.href='/wx-pages/'">预订其他</button>
    </li>
    <?php }else if($state == "已完成" && $customcheck != "ok"){?>
    <li>
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;" type="button" onClick="javascript:location.href='?action=ok&order_ID=<?php echo $order_ID?>'">确认完成</button>
    </li>
    <?php }else if($state == "已完成" && $customcheck == "ok"){?>
    <li>
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;background-color:#CCC;border-color:#CCC" type="button" onClick="javascript:location.href='?action=ok&order_ID=<?php echo $order_ID?>'">您已确认！</button>
    </li>
    <?php }?>
  </ul>
</div>
</div>
<!--content end--> 
<script>
  function cancelorder() {
	  if(confirm("确认取消订单？"))
		  {
			  location.href='?action=cancel&order_ID=<?php echo $order_ID?>';
		   }
		  else
		  {
			  return false;
		  }
  }
  </script>
</body>
</html>