<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <title>会员充值</title> 
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <meta name="apple-mobile-web-app-title" content="Ratchet" /> 
  <link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" />
  <link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" />
  <script src="/wx-pages/script/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<body>
<?php
session_start();
//$_SESSION['openid'] = "oN8WPs8kWI3zaX8ToMMF5brBjdGE";
if (!$_SESSION['openid']) {
	echo "<script>window.location.href='/wx-pages/wx_islogin.php';</script>";
}else{
    $openid = $_SESSION['openid'];
}
?>

<!--table-view end--> 
    <ul class="table-view table-view2" id="onup"> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center;"> 
       <h5><strong style='color:#06C;font-size:18px;'>金卡</strong></h5>
      </div> 
      <div class="table-cell" style="text-align:left;">
        <h6>储值10000元<br/>房管家服务享受<span style="color:#F00">9折</span>优惠</h6>
      </div> 
      <div class="table-cell"> 
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;border-color:#825623;background-color:#825623" type="button" onClick="javascript:location.href='/wx-demo/wx_pay_do.php?level=1&cash=1000000'">购买</button>
      </div> </li> 
     <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center;"> 
       <h5><strong style='color:#06C;font-size:18px;'>白金卡</strong></h5>
      </div> 
      <div class="table-cell" style="text-align:left;">
        <h6>储值20000元<br/>房管家服务享受<span style="color:#F00">8折</span>优惠</h6>
      </div> 
      <div class="table-cell"> 
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;border-color:#825623;background-color:#825623" type="button" onClick="javascript:location.href='/wx-demo/wx_pay_do.php?level=2&cash=2000000'">购买</button>
      </div> </li> 
      <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center;"> 
       <h5><strong style='color:#06C;font-size:18px;'>翡翠卡</strong></h5>
      </div> 
      <div class="table-cell" style="text-align:left;">
        <h6>储值30000元<br/>房管家服务享受<span style="color:#F00">7折</span>优惠</h6>
      </div> 
      <div class="table-cell"> 
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;border-color:#825623;background-color:#825623" type="button" onClick="javascript:location.href='/wx-demo/wx_pay_do.php?level=3&cash=3000000'">购买</button>
      </div> </li> 
      <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center;"> 
       <h5><strong style='color:#06C;font-size:18px;'>钻石卡</strong></h5>
      </div> 
      <div class="table-cell" style="text-align:left;">
        <h6>储值50000元<br/>房管家服务享受<span style="color:#F00">5折</span>优惠</h6>
      </div> 
      <div class="table-cell"> 
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;border-color:#825623;background-color:#825623" type="button" onClick="javascript:location.href='/wx-demo/wx_pay_do.php?level=4&cash=5000000'">购买</button>
      </div> </li> 
      <li class="table-view-cell table-disabled" id="numtable0"> 
      <div class="table-cell" style="text-align:center;">
        <h5><strong style='font-size:18px;'>其他</strong></h5>
      </div> 
      <div class="table-cell" style="vertical-align:middle;"> 
      <input class="ipt" type="text" style="height:40px;margin-bottom:0px;padding:0px;border-color:#FFF" name="otherpay" id="otherpay" placeholder="请输入其他金额" />
      </div>
      <div class="table-cell"> 
      <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;border-color:#825623;background-color:#825623" type="button" id="oc_buy">购买</button>
      </div> </li> 
    </ul> 
    
    <ul class="table-view card"> 
    
     <button class="btn btn-positive btn-positive2" style="width:100%;font-size:18px;border-color:#825623;background-color:#825623" type="button" onClick="javascript:location.href='tel:01059476853'">上门办理</button>

     </ul>
      
<!--bar-tab begin -->
	<div class="bar bar-footer bar-tab">
	    <a class="tab-item " href="/wx-pages/" data-ignore="push">
	        <span class="tab-label">微网站</span>
	    </a>
	    <a class="tab-item" href="/wx-pages/wx_orderlist.php" data-ignore="push">
	        <span class="tab-label">我的订单</span>
	    </a>
	    <a class="tab-item active" data-ignore="push" href="/wx-pages/mypage.php">
	        <span class="tab-label">个人中心</span>
	    </a>
	</div>
<script type="text/javascript">
        $(function () {
			
			 $("#oc_buy").click(function () {
				 var othcash = $("#otherpay").val();
				 var levelstr = 0;
				 if(isPositiveNumber(othcash)){
					 if(10000<=othcash && othcash<20000) levelstr = 1;
					 if(20000<=othcash && othcash<30000) levelstr = 2;
					 if(30000<=othcash && othcash<50000) levelstr = 3;
					 if(50000<=othcash) levelstr = 4;
					 othcash = othcash*100;
					 location.href ="/wx-demo/wx_pay_do.php?level="+levelstr+"&cash="+othcash;
				 }else{
					 $("#otherpay").focus();
					 $("#otherpay").val("金额错误！");
					 inputTipText();
				 }
			 });
        });
		
		function isPositiveNumber(txt){ //是否为正数
		   if(txt == null || txt == ""){return false;}
		   else{
			txt = delSpace(txt);
			if(isNaN(parseInt(txt))){return false;}
			else{
			 return (parseInt(txt) > 0);
			}
		   }
	    }
		
	   function delSpace(txt){ //清除字符串中所有的空白字符
		   if(txt == null ){
			return "";
		   }else{
			txt = txt.toString();
			txt = txt.replace(/\s{1,}/,"");
			return txt;
		   }
	  }
	 
     </script>

</body>
</html>