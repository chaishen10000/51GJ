<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base href=".">

    <title>51管家</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Ratchet">
    <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/ratchet.min.css?v=20150408">
    <link rel="stylesheet" href="css/index.css?v=20150408">
    <link href="css/else.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="script/config.js"></script>
    <script type="text/javascript" src="script/wx_main.js"></script> 
	<script src="script/require.js" data-main="main"></script>


<meta charset="utf-8">
</head>
<body>
<!--bar-nav begin-->
<header class="bar bar-nav">
    <div class="pull-left">
        <a class="bar-logo" data-ignore="push"></a>
    </div>
    <div class="pull-right">
        <a class="bar-tel" href="tel:01059476853" data-ignore="push"></a>
    </div>
</header>
<!--bar-nav end-->
<?php
session_start();
?>
<!--content begin-->
<div class="content content-index">
    <!--swipe begin-->
    <div id="mySwipe" class="swipe" style="visibility: visible;">
        <div class="swipe-wrap" style="width: 3084px;">
            
	  			<div data-index="0" style="width: 1542px; left: 0px; transition: 300ms; -webkit-transition: 300ms; -webkit-transform: translate(-1542px, 0px) translateZ(0px);"><a href="#" data-ignore="push"><img src="images/banner01_wx.jpg" width="100%"></a></div>
	  		
	  			<div data-index="1" style="width: 1542px; left: -1542px; transition: 300ms; -webkit-transition: 300ms; -webkit-transform: translate(0px, 0px) translateZ(0px);"><a href="/wx-pages/wx_member.php" data-ignore="push"><img src="images/banner02.jpg" width="100%"></a></div>
	  		
        </div>
        <div class="slider-dots"> 	
            <span class=""></span>
            <span class="cur"></span>
        </div>
    </div>
    <!--swipe end-->

    <div class="table-view table-view5" data-role="i2">
        <a class="table-cell" href="/wx-pages/wx_houseservice.php" data-ignore="push">
            <p><i class="ico-clean"></i></p>
            <h4>房管家</h4>
            <div>定期维护、打扫、抽湿</div>
        </a>
        
	        <a class="table-cell" href="/wx-pages/wx_member.php" data-ignore="push">
	        <!-- <a class="table-cell" href="/order/cart?categoryid=107" data-ignore="push"> -->
	            <p><i class="ico-1yuan"></i></p>
	            <h4>会员尊享</h4>
	            <div>多项特权，尊贵享受！</div>
	        </a>
        
    </div>
    <!--table-view end-->
    <div class="table-view table-view5" data-role="i2">
        <a class="table-cell" href="/wx-pages/wx_carservice.php" data-ignore="push">
            <p><i class="ico-jc"></i></p>
            <h4>车管家</h4>
            <div>养护、行驶、保险！</div>
        </a>
            <a class="table-cell" href="/wx-pages/wx_lifeservice.php" data-ignore="push">
            <p><i class="ico-zq"></i></p>
            <h4>生活管家</h4>
            <div>行程安排，代办代购！</div>
        </a>
        
    </div>
    
    <!--table-view end-->
    
    <div class="table-view table-view5" data-role="i2">
	        <a class="table-cell" onClick="javascript:noticeDialog('即将上线，敬请期待！',5000);" data-ignore="push">
	            <p><i class="ico-zh"></i></p>
	            <h4>管家商城</h4>
	            <div>我们只提供高品质商品！</div>
	        </a>
            <a class="table-cell" onClick="javascript:noticeDialog('欢迎致电：01059476853<br/>告诉我们您的需求！',5000);" data-ignore="push">
	        <!-- <a class="table-cell" href="/order/cart?categoryid=107" data-ignore="push"> -->
	            <p><i class="ico-gd"></i></p>
                <h4>私人订制</h4>
                <div>游艇、飞机、租房、租车！</div>
	        </a>
        
    </div>
    <!--table-view end-->
    
    <!--bar-tab begin -->
	<div class="bar bar-footer bar-tab">
	    <a class="tab-item active" href="/wx-pages/" data-ignore="push">
	        <span class="tab-label">微网站</span>
	    </a>
	    <a class="tab-item" href="/wx-pages/wx_orderlist.php" data-ignore="push">
	        <span class="tab-label">我的订单</span>
	    </a>
	    <a class="tab-item" data-ignore="push" href="/wx-pages/mypage.php">
	        <span class="tab-label">个人中心</span>
	    </a>
	</div>
    <!--bar-tab end-->
</div>
<!--content end-->


<!-- 登录弹窗 -->
<script type="text/template" id="loginTpl">
    <form class="frm" action="/user/validate">
        <div class="input-row">
            <label>输入手机号</label>
            <input type="text" name="phone" id="phone">
        </div>
        <div class="input-table" col="2">
            <div class="table-cell">
                <input name="validatecode" id="validatecode" class="ipt-sms" type="text" placeholder="短信验证码">
            </div>
            <div class="table-cell"  id="getSMS">
                <button type="button" data-act="getSMS" class="btn btn-positive btn-block" onclick="javascript:getCode();">获取验证码</button>
            </div>
        </div>

        <div class="btn-row">
            <button type="button" class="btn btn-positive btn-positive2 btn-block" onclick="javascript:validateCode();">登录</button>
        </div>
    </form>
</script>
<!-- 登录弹窗 -->


<script type="text/javascript">
</script>
</body></html>