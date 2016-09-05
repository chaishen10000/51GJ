<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>住前打理</title>
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
			$strtemp.= "<li class='table-view-cell addressfrontjs' data-f='".$value['f']."' data-ID='" . $value['property_ID'] . "'> <i class='ico-map-marker'></i><div class='ipt'/>";
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
  <meta charset="utf-8" />
  </head>

  <body>
<form name="fm1" method="post" action="" id="fm1" novalidate>
    <!--content begin-->
    <div class="content content2"> 
    <!--banner begin-->
    <div class="banner"> <a href="/wx-pages/fwjs.htm" data-ignore="push">
      <div> <img src="/wx-pages/images/sd_front.jpg" width="100%" alt="" /> </div>
      <div class="banner-nav navigate-right"> 查看服务介绍 </div>
      </a> </div>
    <!--banner end-->
    <div class="table-mod">
        <div class="table-mod">
        <h4>*请选择您需要的房管家服务</h4>
        <ul class="table-view card">
        <li class='table-view-cell'> <i class='ico-tags'></i>
           <div class='ipt'/>
           <a href="/wx-pages/wx_houseservice.php">房屋定期保养</a>
           </div>
        </li>
        <li class='table-view-cell houseservice typeClick'> <i class='ico-tags'></i>
           <div class='ipt'/>
           住前打扫
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
        <li class='table-view-cell addressfrontjs'> <i class='ico-map-marker'></i>
        <div class='ipt'/>
        <a href="/wx-pages/wx_property.php">添加新物业</a>
      </div>
        </li>
      </ul>
  </div>
    <!--table-view end-->
    <div class="tab-cnt tab-cnt-view" style="display: block;">
    <div class="table-view">
        <div class="table-view-cell"> <i class="ico-serv"> <img src="http://xiaomaguanjia.com/res/icon/fw.png" width="100%" alt=""> </i>
        <h5>服务范围</h5>
        <div>包括客厅、卫生间、厨房、卧室等全屋清洁，洗衣机、空调、冰箱、油烟机等全屋大家电的清洗，整床、沙发、窗帘的除尘除螨。</div>
      </div>
        <div class="table-view-cell"> <i class="ico-serv"> <img src="http://xiaomaguanjia.com/res/icon/bz.png" width="100%" alt=""> </i>
        <h5>服务标准</h5>
        <div>整体无尘、物品摆放整齐，无水渍。</div>
      </div>
      </div>
  </div>
    <div class="table-mod">
    <h4>填写预约信息</h4>
    <ul class="table-view card">
        <li class="table-view-cell"> <i class="ico-bell"></i>
        <input class="ipt" type="text" name="time_serv" id="time_serv" placeholder="请选择服务时间"/>
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
    <input type="hidden" name="type" id="type" value="住前打理" />
    <input type="hidden" class="ipt" name="service" id="service" />
    <input type="hidden" class="ipt" name="total_fee" id="total_fee" />
    <input type="hidden" class="ipt" name="cash_fee" id="cash_fee" />
  </form>
<div id="datePlugin"></div>
</body>
</html>