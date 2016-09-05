<!DOCTYPE html>
<html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>房管家</title>
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
	if (!isset($_SESSION['openid'])||$_SESSION['openid']=="") {
		echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
	} else {
		$openid = $_SESSION['openid'];
		$row = $db->row_select("wx_property", "type = 'house' and openid='" . $openid . "'", 0, "*", "property_ID");
		$strtemp = "";
		foreach ($row as $key => $value) {
			$address = $value['e'];
			$area = $value['f'];
			if(mb_strlen($address,'UTF8')>13){
			$address = mb_substr($address, 0, 6, 'utf-8') . "..." . mb_substr($address, -7, 7, 'utf-8');
			}
			$strtemp.= "<li class='table-view-cell addressonejs' data-f='".$value['f']."' data-ID='" . $value['property_ID'] . "'> <i class='ico-map-marker'></i><div class='ipt'/>";
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
  <script type="text/javascript">
	  var discount = <?php echo $discount;?>; 
	  var area = 0;
  </script>
  <script type="text/javascript" src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script>
  <script type="text/javascript" src="/wx-pages/script/wx_main.js"></script>
  <script type="text/javascript" src="/wx-pages/script/date_main.js" ></script>
  <script type="text/javascript" src="/wx-pages/script/date_iscroll.js" ></script>
  <script type="text/javascript">
      
	  $(function(){
		  //$('#time').date();//只显示日期，不显示时间
		  $('#time_serv').date({theme:"date"}); //显示日期及时间
	  });
  </script>
  <meta charset="utf-8" />
  </head>

  <body>
<form name="fm1" method="post" action="" id="fm1" novalidate>
    <!--content begin-->
    <div class="content content2"> 
    <!--banner begin-->
    <div class="banner"> <a href="/wx-pages/fwjs.htm" data-ignore="push">
      <div> <img src="/wx-pages/images/sd_one.jpg" width="100%" alt="" /> </div>
      <div class="banner-nav navigate-right"> 查看服务介绍 </div>
      </a> </div>
    <!--banner end-->
    <div class="table-mod">
        <div class="table-mod">
        <h4>*请选择您需要的房管家服务</h4>
        <ul class="table-view card">
        <li class='table-view-cell houseservice typeClick'> <i class='ico-tags'></i>
           <div class='ipt'/>
           房屋定期保养
           </div>
        </li>
        <li class='table-view-cell'> <i class='ico-tags'></i>
           <div class='ipt'/>
           <a href="/wx-pages/wx_housefront.php">住前打扫</a>
           </div>
        </li>
        <li class='table-view-cell'> <i class='ico-tags'></i>
           <div class='ipt'/>
           <a href="/wx-pages/wx_houseafter.php">住后整理</a>
           </div>
        </li>
      </ul>
      </div>
    <div class="table-mod">
    <h4>*请选择需要服务的物业</h4>
    <ul class="table-view card">
        <?php echo $strtemp;?>
        <li class='table-view-cell'> <i class='ico-map-marker'></i>
        <div class='ipt'/>
        <a href="/wx-pages/wx_property.php">添加新物业</a>
      </div>
        </li>
      </ul>
  </div>
    <!--table-view end-->
    <div class="tab-cnt tab-cnt-view" style="display: block;">
    <div class="table-view">
        <div class="table-view-cell"> <i class="ico-serv"> <img src="/wx-pages/images/fw.png" width="100%" alt=""> </i>
        <h5>服务范围</h5>
        <div>包括:每月指定次数的一小时的开窗通风、室内地面清洁、家里植物浇水、检查有无漏水、漏电、漏气，登记水、电、气数字、房子有其它问题及时和您沟通及后续协助处理。根据需要灭鼠灭蟑螂。<br/><span style="color:#F00">*活动期间赠送一年12次的房管家服务（200平米以内）</span></div>
      </div>
        <div class="table-view-cell"> <i class="ico-serv"> <img src="/wx-pages/images/bz.png" width="100%" alt=""> </i>
        <h5>服务标准</h5>
        <div>做到整体无尘、物品摆放整齐，去除油渍及水渍。</div>
      </div>
      </div>
  </div>
    <div class="table-mod">
    <h4>填写预定信息</h4>
      <ul class="table-view card">
        <li class="table-view-cell coupons" id="coupons_view"> <i class="ico-checked"></i>
           <h5><span style="color:#F60">优惠包：</span>赠送一年12次房管家服务！</h5>
        </li>
        <li class="table-view-cell" id="coupons_view"> <i class="ico-tags"></i>
          <select name="period" id="period" class="selecttb">
            <option value="12">服务期限（一年，赠送）</option>
            <option value="18">服务期限（一年半）</option>
            <option value="24">服务期限（两年）</option>
            <option value="30">服务期限（两年半）</option>
            <option value="36">服务期限（三年）</option>
            <option value="48">服务期限（四年）</option>
            <option value="60">服务期限（五年）</option>
          </select>
        </li>
        <li class="table-view-cell" id="coupons_view"> <i class="ico-tags"></i>
          <select name="frequency" id="frequency" class="selecttb">
            <option value="1">每月频次（一次，赠送）</option>
            <option value="2">每月频次（两次）</option>
            <option value="3">每月频次（三次）</option>
            <option value="4">每月频次（四次）</option>
            <option value="5">每月频次（五次）</option>
            <option value="6">每月频次（六次）</option>
          </select>
        </li>
        <li class="table-view-cell"> <i class="ico-bell"></i>
        <input class="ipt" type="text" name="time_serv" id="time_serv" placeholder="请选择开始服务的时间"/>
        </li>
        <li class="table-view-cell"> <i class="ico-remark"></i>
        <input class="ipt" type="text" name="remarks" placeholder="备注：如特殊要求，联系方式" />
        </li>
      </ul>
  </div>
    </div>
    <!--content end-->
    <div class="bar bar-footer">
    <div class="price pull-left"> <span class="price-real brush2"><strong><span id="realityprice"></span></strong></span> <span class="through"><span id="originalprice"></span></span> </div>
    <div class="pull-right">
        <button class="btn btn-positive btn-positive2" type="button" onclick="javascript:submitOneValidate();" id="orderbt">提交订单</button>
      </div>
  </div>
    <input type="hidden" class="ipt" name="property_ID" id="property_ID" value="" />
    <input type="hidden" name="openid" id="openid" value="<?php echo $openid;?>" />
    <input type="hidden" name="type" id="type" value="房管家" />
    <input type="hidden" class="ipt" name="service" id="service" />
    <input type="hidden" class="ipt" name="servfreq" id="servfreq" />
    <input type="hidden" class="ipt" name="total_fee" id="total_fee" />
    <input type="hidden" class="ipt" name="cash_fee" id="cash_fee" />
    
  </form>
<div id="datePlugin"></div>
</body>
</html>