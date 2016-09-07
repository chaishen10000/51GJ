<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <title>下单成功</title> 
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <meta name="apple-mobile-web-app-title" content="Ratchet" /> 
  <link rel="stylesheet" href="/wx-admin/css/ratchet.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-admin/css/style.css?v=20150408" /> 

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
if (1>2) {
	echo "<script>window.location.href='/wx-admin/islogin.php';</script>";
}else{
	$order_ID = $_GET["order_ID"];
	$openid = $_SESSION['openid'];
	$row = $db->row_select("wx_order", "order_ID=" . $order_ID , 1, "*", "order_ID");
	foreach ($row as $key => $value) {
		$type = $value['type'];
		$service = $value['service'];
		$time_serv = $value['time_serv'];
		$property_ID = $value['property_ID'];
		$cash_fee = (int)$value['cash_fee'];
		$cash_fee1 = $cash_fee/100;
		$total_fee = (int)$value['total_fee'];
		$total_fee1 = $total_fee/100;
		$remarks = $value['remarks'];
    }
	$row = $db->row_select("wx_property", "property_ID=" . $property_ID , 1, "e", "property_ID");
	foreach ($row as $key => $value) {
		$address = $value['e'];
    }
	$obj=json_decode($service); 
	$sqlstr = ""; 
	//车管家
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
	
	$smm = new template_message();
	$openid1 = "oN8WPs90EDEsJkdj8t-bBVukaD0o";
	$openid2 = "oN8WPs_DS8nApKcDwzqcmAuuscwo";
	$openid3 = "oN8WPs8kWI3zaX8ToMMF5brBjdGE";
	$openid4 = "oN8WPs26f6Rqt3ell6o0-A-UEmco";
	$smm->send_manager_message($order_ID,$openid1,$time_serv,$type,$address,$remarks);
	$smm->send_manager_message($order_ID,$openid2,$time_serv,$type,$address,$remarks);
	$smm->send_manager_message($order_ID,$openid3,$time_serv,$type,$address,$remarks);
	$smm->send_manager_message($order_ID,$openid4,$time_serv,$type,$address,$remarks);
	//$smm->send_customer_message($order_ID,$openid,$time_serv,$type,$address,$remarks);
}

function getserviceitem($db,$class)
{
    $row = $db->row_select("wx_service", "class='".$class."'", 1, "itemname", "service_ID");
	foreach ($row as $key => $value) {
		$itemname = $value['itemname'];
    } 
	return $itemname;
}
?>
<form name="fm1" method="post" action="" id="fm1" novalidate>
    <!--banner begin--> 
    <div class="banner" style="text-align:center;"> 
      <h4>&nbsp;</h4>
      <span style="color:#E6550F; font-size:24px; font-weight:bold">设定订单费用</span> 
    </div> 
    <!--banner end--> 
    <ul class="table-view table-view2" id="onup"> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center; font-weight:700;"> 
       项目 
      </div> 
      <div class="table-cell" style="text-align:left; ">
       <?php echo $type;?> 
      </div> 
     </li> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center; font-weight:700;"> 
       内容 
      </div> 
      <div class="table-cell" style="text-align:left; ">
       <?php echo $sqlstr;?>
      </div> 
     </li> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center; font-weight:700;"> 
       时间 
      </div> 
      <div class="table-cell" style="text-align:left; ">
       <?php echo $time_serv;?>
      </div> 
     </li> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center; font-weight:700;"> 
       地址 
      </div> 
      <div class="table-cell" style="text-align:left; ">
       <?php echo $address;?> 
      </div> 
     </li> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center; font-weight:700;"> 
       价格 
      </div> 
      <div class="table-cell" style="text-align:left; ">
        <?php echo $cash_fee1;?>元
        <?php if($cash_fee1<$total_fee1){?>（<span style="text-decoration:line-through"><?php echo $total_fee1;?></span>元）
        <?php }?> 
        <?php if($type=="车管家"){?>（服务费）
        <?php }?> 
      </div> 
     </li> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center; font-weight:700;"> 
       第三方<br/>费用 
      </div> 
      <div class="table-cell" style="text-align:left; ">
       <input class="noborderbutton" type="text" name="third_part_fee" id="third_part_fee" placeholder="务必电话确认后再输入" />
      </div> 
     </li>
    </ul> 
    <div class=""> 
       
     <ul class="table-view card table_list">
     <li> 
     <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;" type="button" onClick="javascript:location.href='/wx-pages/'">回首页</button>
     </li>
     <li>
     <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;background-color:#E36406; border-color:#E36406" type="button" id="updata_tpf" onclick="javascript:submitTPFValidate();">提交订单</button>
     <input type="hidden" name="order_ID" id="order_ID" value="<?php echo $order_ID;?>"/>
     <input type="hidden" name="type" id="type" value="车管家"/>
     <input type="hidden" name="openid" id="openid" value="<?php echo $openid;?>" />
     <input type="hidden" name="$total_fee1" id="$total_fee1" value="<?php echo $total_fee1;?>" />
     </li>
     </ul> 
    </div> 
   </div> 
   <!--content end--> 
 </form>
 <script type="text/javascript" src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script>
 <script type="text/javascript" src="/wx-admin/script/wx_main.js"></script>
 </body>
</html>