<!DOCTYPE html>
<!-- saved from url=(0049)http://weixin.lzmuwu.com/superiority/default.aspx -->
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection">
<title>个人中心</title>
<link href="/wx-pages/css/bootstrap.min.css" rel="stylesheet">
<link href="/wx-pages/css/common.css" rel="stylesheet" type="text/css">
<link href="/wx-pages/css/else.css" rel="stylesheet" type="text/css">
<link href="/wx-pages/css/ratchet.css?v=20150408" rel="stylesheet" />
<link href="/wx-pages/css/style.css?v=20150408" rel="stylesheet" />
<script src="/wx-pages/script/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/wx-pages/script/wx_main.js"></script> 
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<style type="text/css">
.pageBox table {
	width: 100%;
	-moz-box-shadow: 0 2px 3px #d1d1d1;
	-webkit-box-shadow: 0 2px 3px #d1d1d1;
	box-shadow: 0 2px 3px #d1d1d1;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	background: #fff;
	margin-bottom: 2%;
	padding-top: 2%;
	padding-bottom: 2%;
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
	  $row = $db->row_select("wp_users", "openid='" . $_SESSION['openid'] . "'", 1, '*', 'ID');
	  if (!empty($row)) {
            foreach ($row as $key => $value) {
				$realname = $value['display_name'];
				if(empty($realname)){
					$realname = $value['user_nicename'];
				}
				$realname = $value['display_name'];
				$level = $value['now_level'];
				$user_cash = (int)$value['user_cash'];
				$user_cash = $user_cash/100;
				$headimgurl = $value['user_url']; 
			}
			if($level==0) $levelname = "普通会员";
			if($level==1) $levelname = "金卡会员";
			if($level==2) $levelname = "白金会员";
			if($level==3) $levelname = "翡翠会员";
			if($level==4) $levelname = "钻石会员";
	  }
  }
?>
<div class="mainWarp clearfix">
  <div class="pageBox clearfix">
 
    <div class="ptTop">
      <p class="txImg clearfix"> <img style="-webkit-user-select: none; cursor: -webkit-zoom-in;" src="<?php echo $headimgurl;?>"> <a href="#"><?php echo $realname ;?></a></p>
      <div class="right">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td style="padding-left:2%;"><img src="/wx-pages/images/icon004.jpg" alt=""> </td><td><?php echo $levelname;?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="clear"></p>
    </div>
    <a href="/wx-pages/wx_member.php">
    <table border="0" cellpadding="0" cellspacing="0" class="ysTable">
      <tbody>
        <tr>
          <th rowspan="2"> +</th>
          <td><h4><strong>账户余额：</strong></h4></td>
          <td align="right"><h4><strong style="color:#F00; padding:10%">&nbsp;￥<?php echo $user_cash;?></strong></h4></td>
        </tr>
      </tbody>
    </table>
    </a><a href="/wx-pages/wx_property.php">
    <table border="0" cellpadding="0" cellspacing="0" class="ysTable">
      <tbody>
        <tr>
          
          <th rowspan="2"> +</th>
          <td><h4><strong>管理物业信息：</strong></h4></td>
          <td align="right"><h4><strong style="padding:10%">&nbsp;></strong></h4></td>
          
        </tr>
      </tbody>
    </table>
    </a>
    <a href="/wx-pages/wx_car.php">
    <table border="0" cellpadding="0" cellspacing="0" class="ysTable">
      <tbody>
        <tr>
          
          <th rowspan="2"> +</th>
          <td><h4><strong>管理车辆信息：</strong></h4></td>
          <td align="right"><h4><strong style="padding:10%">&nbsp;></strong></h4></td>
          
        </tr>
      </tbody>
    </table></a>
    <a onClick="javascript:noticeDialog('历史订单尚未生成！',1000);">
    <table border="0" cellpadding="0" cellspacing="0" class="ysTable">
      <tbody>
        <tr>
          
          <th rowspan="2"> +</th>
          <td><h4><strong>历史订单：</strong></h4></td>
          <td align="right"><h4><strong style="padding:10%">&nbsp;></strong></h4></td>
          
        </tr>
      </tbody>
    </table></a>
  </div>
</div>
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
    <!--bar-tab end-->
</body>
</html>