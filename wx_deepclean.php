<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <title>深度清洁</title> 
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <meta name="apple-mobile-web-app-title" content="Ratchet" /> 
  <link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/index.css" /> 
  <link rel="stylesheet" href="/wx-pages/css/date_common.css" />
  <script type="text/javascript">
	  /**
	   *防止“返回”本页面，导致订单数据错误。
	   */
	  if (e.NavigationMode == NavigationMode.Back){
		  location.reload(true);  
	  }
  </script>
  <?php
	include ('includes/dbconfig.php');
	session_start();
	//$_SESSION['openid'] = "oN8WPs8kWI3zaX8ToMMF5brBjdGE";
	if (!$_SESSION['openid']) {
		echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
	} else {
		$openid = $_SESSION['openid'];
		$row = $db->row_select("wx_property", "type = 'house' and openid='" . $openid . "'", 0, "*", "property_ID");
		$strtemp = "";
		foreach ($row as $key => $value) {
			$address = $value['e'];
			if(mb_strlen($address,'UTF8')>13){
			$address = mb_substr($address, 0, 6, 'utf-8') . "..." . mb_substr($address, -7, 7, 'utf-8');
			}
			$strtemp.= "<li class='table-view-cell addressjs' data-ID='" . $value['property_ID'] . "'> <i class='ico-map-marker'></i><div class='ipt'/>";
			$strtemp.= $address;
			$strtemp.= '</div></li>';
		}
		$row1 = $db->row_select("wp_users", "openid='" . $openid . "'", 1, "now_level", "ID");
		foreach ($row1 as $key => $value) {
			$level = $value['now_level'];
		}
		$row2 = $db->row_select("wx_member", "level=" . $level, 1, "discount", "ID");;
		foreach ($row2 as $key => $value) {
			$discount = $value['discount'];
		}
	}
?>
  <script type="text/javascript">var discount = <?php echo $discount;?></script>
  <script type="text/javascript" src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script> 
  <script type="text/javascript" src="/wx-pages/script/wx_main.js"></script> 
  <script type="text/javascript" src="/wx-pages/script/date_main.js" ></script>
  <script type="text/javascript" src="/wx-pages/script/date_iscroll.js" ></script>
  <script type="text/javascript">
      
	  $(function(){
		  //$('#time').date();//只显示日期，不显示时间
		  $('#time_serv').date({theme:"datetime"}); //显示日期及时间
	  });
  </script>
  <script type="text/javascript">
	  /**
	   *获取units封装json
	   */
	  function getUnits() {
		  var units = "";
			  var unitid21 = $("#unitid21").val();
			  if (unitid21 != undefined && unitid21 != "" && unitid21!= null && Number(unitid21) != 0) {
				  units = units + "\"21\":" + unitid21 + ",";
			  }
		  
			  var unitid22 = $("#unitid22").val();
			  if (unitid22 != undefined && unitid22 != "" && unitid22!= null && Number(unitid22) != 0) {
				  units = units + "\"22\":" + unitid22 + ",";
			  }
		  
			  var unitid23 = $("#unitid23").val();
			  if (unitid23 != undefined && unitid23 != "" && unitid23!= null && Number(unitid23) != 0) {
				  units = units + "\"23\":" + unitid23 + ",";
			  }
		  
			  var unitid24 = $("#unitid24").val();
			  if (unitid24 != undefined && unitid24 != "" && unitid24!= null && Number(unitid24) != 0) {
				  units = units + "\"24\":" + unitid24 + ",";
			  }
		  
		  if(units != ""){
			  units = units.substring(0, units.length - 1);
			  units = "{" + units + "}";
		  }
		  //alert(units);
		  return units;
	  }

  </script>
 <meta charset="utf-8" /> 
 </head> 

 <body> 
  <form name="fm1" method="post" action="" id="fm1" novalidate>
   <!--content begin--> 
   <div class="content content2"> 
    <!--banner begin--> 
    <div class="banner"> 
     <a href="/wx-pages/fwjs.htm" data-ignore="push"> 
      <div> 
       <img src="/wx-pages/images/sd_head.jpg" width="100%" alt="" /> 
      </div> 
      <div class="banner-nav navigate-right">
        查看服务介绍 
      </div> </a> 
    </div> 
    <!--banner end--> 
    <div class="table-mod"> 
     <h4>*请选择需要服务的物业</h4> 
     <ul class="table-view card"> 
      <?php echo $strtemp;?> 
      <li class='table-view-cell addressjs'> <i class='ico-map-marker'></i><div class='ipt'/><a href="/wx-pages/wx_property.php">添加新物业</a></div></li>
     </ul> 
    </div> 
    <!--table-view end--> 
    <ul class="table-view table-view2" id="onup"> 
     <input type="hidden" name="unitid21" id="unitid21" /> 
     <li class="table-view-cell table-disabled" id="numtable21"> 
      <div class="table-cell" onclick="javascript:delUnit('21',398);"> 
       <i class="ico ico-minus"></i> 
      </div> 
      <div class="table-cell">
        厨房 
       <div class="num" id="num21">
         x0 
       </div> 
      </div> 
      <div class="table-cell" onclick="javascript:addUnit('21',398);"> 
       <i class="ico ico-plus"></i> 
      </div> </li> 
     <input type="hidden" name="unitid22" id="unitid22" /> 
     <li class="table-view-cell table-disabled" id="numtable22"> 
      <div class="table-cell" onclick="javascript:delUnit('22',198);"> 
       <i class="ico ico-minus"></i> 
      </div> 
      <div class="table-cell">
        卫生间 
       <div class="num" id="num22">
         x0 
       </div> 
      </div> 
      <div class="table-cell" onclick="javascript:addUnit('22',198);"> 
       <i class="ico ico-plus"></i> 
      </div> </li> 
     <input type="hidden" name="unitid23" id="unitid23" /> 
     <li class="table-view-cell table-disabled" id="numtable23"> 
      <div class="table-cell" onclick="javascript:delUnit('23',298);"> 
       <i class="ico ico-minus"></i> 
      </div> 
      <div class="table-cell">
        客厅 
       <div class="num" id="num23">
         x0 
       </div> 
      </div> 
      <div class="table-cell" onclick="javascript:addUnit('23',298);"> 
       <i class="ico ico-plus"></i> 
      </div> </li> 
     <input type="hidden" name="unitid24" id="unitid24" /> 
     <li class="table-view-cell table-disabled" id="numtable24"> 
      <div class="table-cell" onclick="javascript:delUnit('24',128);"> 
       <i class="ico ico-minus"></i> 
      </div> 
      <div class="table-cell">
        卧室 
       <div class="num" id="num24">
         x0 
       </div> 
      </div> 
      <div class="table-cell" onclick="javascript:addUnit('24',128);"> 
       <i class="ico ico-plus"></i> 
      </div> </li> 
    </ul> 
    <div class="table-mod"> 
     <h4>填写预约信息</h4> 
     <ul class="table-view card"> 
      <li class="table-view-cell"> <i class="ico-bell"></i> <input class="ipt" type="text" name="time_serv" id="time_serv" placeholder="请选择服务时间"/>  </li> 
      <li class="table-view-cell"> <i class="ico-remark"></i> <input class="ipt" type="text" name="remarks" placeholder="请填写您的特殊要求" /> </li>  
     </ul> 
    </div> 
   </div> 
   <!--content end--> 
   <div class="bar bar-footer"> 
    <div class="price pull-left"> 
     <span class="price-real brush2"><strong><span id="realityprice"></span></strong></span> 
     <span class="through"><span id="originalprice"></span></span> 
    </div> 
    <div class="pull-right"> 
     <button class="btn btn-positive btn-positive2" type="button" onclick="javascript:submitValidate();" id="orderbt">提交订单</button> 
    </div> 
   </div> 
   <input type="hidden" class="ipt" name="property_ID" id="property_ID" value="" />
   <input type="hidden" name="openid" id="openid" value="<?php echo $openid;?>" />
   <input type="hidden" name="type" id="type" value="深度清洁" />    
   <input type="hidden" class="ipt" name="service" id="service" /> 
   <input type="hidden" class="ipt" name="total_fee" id="total_fee" /> 
   <input type="hidden" class="ipt" name="cash_fee" id="cash_fee" />
  </form> 
  <div id="datePlugin"></div>
 </body>
</html>