<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <title>下单成功</title> 
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <meta name="apple-mobile-web-app-title" content="Ratchet" /> 
  <link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" /> 

  <style type="text/css"> 
	.table_list{overflow:hidden;zoom:1;} 
	.table_list li{ width:50%;float:left;} 
  </style> 
  <meta charset="utf-8" /> 
 </head> 
 <body> 
 <?php
include ('includes/dbconfig.php');
include ('../wx-admin/includes/wx_message_class.php');
session_start();
if (!$_SESSION['openid']) {
	echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
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
	//常规清洁
    if(isset($obj->{'11'}))
	   $sqlstr .= getserviceitem($db,'11')."x".$obj->{'11'}." "; 
	if(isset($obj->{'12'}))
	   $sqlstr .= getserviceitem($db,'12')."x".$obj->{'12'}." "; 
	if(isset($obj->{'13'}))
	   $sqlstr .= getserviceitem($db,'13')."x".$obj->{'13'}." "; 
	if(isset($obj->{'14'}))
	   $sqlstr .= getserviceitem($db,'14')."x".$obj->{'14'}." "; 
	//深度清洁
	if(isset($obj->{'21'}))
	   $sqlstr .= getserviceitem($db,'21')."x".$obj->{'21'}." "; 
	if(isset($obj->{'22'}))
	   $sqlstr .= getserviceitem($db,'22')."x".$obj->{'22'}." "; 
	if(isset($obj->{'23'}))
	   $sqlstr .= getserviceitem($db,'23')."x".$obj->{'23'}." "; 
	if(isset($obj->{'24'}))
	   $sqlstr .= getserviceitem($db,'24')."x".$obj->{'24'}." "; 
	//除尘除螨
	if(isset($obj->{'31'}))
	   $sqlstr .= getserviceitem($db,'31')."x".$obj->{'31'}." "; 
	if(isset($obj->{'32'}))
	   $sqlstr .= getserviceitem($db,'32')."x".$obj->{'32'}." "; 
	if(isset($obj->{'33'}))
	   $sqlstr .= getserviceitem($db,'33')."x".$obj->{'33'}." "; 
	if(isset($obj->{'34'}))
	   $sqlstr .= getserviceitem($db,'34')."x".$obj->{'34'}." "; 
	//家电清洁
	if(isset($obj->{'41'}))
	   $sqlstr .= getserviceitem($db,'41')."x".$obj->{'41'}." "; 
	if(isset($obj->{'42'}))
	   $sqlstr .= getserviceitem($db,'42')."x".$obj->{'42'}." "; 
	if(isset($obj->{'43'}))
	   $sqlstr .= getserviceitem($db,'43')."x".$obj->{'43'}." "; 
	if(isset($obj->{'44'}))
	   $sqlstr .= getserviceitem($db,'44')."x".$obj->{'44'}." "; 
	if(isset($obj->{'45'}))
	   $sqlstr .= getserviceitem($db,'45')."x".$obj->{'45'}." ";
	if($type=="房管家") $sqlstr = "房管家整体清洁养护";
	if($type=="住前打理") $sqlstr = "住前整体清洁、整理";
	if($type=="住后整理") $sqlstr = "住后整体清洁、整理";
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
	$smm->send_customer_message($order_ID,$openid,$time_serv,$type,$address,$remarks);
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
    <!--banner begin--> 
    <div class="banner"> 
      <h4>&nbsp;</h4>
      <div style="text-align:center;"> 
       <img style="margin:0 auto;" src="/wx-pages/images/ordersuccess.png" width="30%" alt="" /> 
      </div> 
      <h4>&nbsp;</h4>
      <h3 style="text-align:center;color:#E6550F">恭喜您，下单成功！</h3> 
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
       备注 
      </div> 
      <div class="table-cell" style="text-align:left; ">
       <?php if($type=="车管家"){?><span style="color:#E36406; font-size:14px">第三方费用,将由专人在服务前与您核实确认后垫付，服务完成后按实际发生金额结算。</span>
       <?php }?> 
      </div> 
     </li>
    </ul> 
    <div class="table-mod"> 
       
     <ul class="table-view card table_list">
     <li> 
     <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;" type="button" onClick="javascript:location.href='/wx-pages/'">回首页</button>
     </li>
     <li>
     <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;background-color:#E36406; border-color:#E36406" type="button" onClick="javascript:location.href='/wx-pages/wx_orderlist.php'">查看订单</button>
     </li>
     </ul> 
    </div> 
   </div> 
   <!--content end--> 
  
 </body>
</html>