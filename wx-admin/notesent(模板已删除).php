<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <title>通用通知通告</title> 
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <meta name="apple-mobile-web-app-title" content="Ratchet" /> 
  <link rel="stylesheet" href="/wx-pages/css/ratchet.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/style.css?v=20150408" /> 
  <link rel="stylesheet" href="/wx-pages/css/index.css?v=20150408">
  <script type='text/javascript' src='http://libs.useso.com/js/jquery/1.6.1/jquery.min.js'></script>
  <script type="text/javascript" src="/wp-includes/js/jquery/jquery.form.js"></script>
  <script type='text/javascript' src='/wx-admin/script/admin_main.js'></script>
  <style type="text/css"> 
	.table_list{overflow:hidden;zoom:1;} 
	.table_list li{ width:50%;float:left;} 
  </style> 
  <meta charset="utf-8" /> 
 </head> 
 <body> 
<?php
include ('includes/wx_message_class.php');
session_start();
if (!$_SESSION['openid']||$_SESSION['user_level'] <2 ) {
	echo "<script>window.location.href='/wx-admin/islogin.php';</script>";
}else{
	if (isset($_GET["openid"])&&isset($_GET["notestr"])) {
		$openid = $_GET["openid"];
		$notequestion = $_GET["notequestion"];
		$notestr = $_GET["notestr"];
		$scp = new template_message();
		$scp->send_customer_note("尊敬的客户，您的反馈我们已收到：","关于‘".$notequestion."’的问题",$openid, date('Y-m-d',time()), $notestr, "如有任何意见或建议请直接回复，或拨打电话：010-59476853");
    }
}
?>
    <!--banner begin--> 
    <!--banner begin--> 
    <div class="banner"> 
      <div style="text-align:center;"> 
       <img style="margin:0 auto;" src="/wx-pages/images/none.png" width="100%" alt="" /> 
      </div> 
      <h3 style="text-align:center;color:#E6550F">通用通知通告</h3> 
    </div> 
    <!--banner end--> 
    <form action="" method="get" name="noteform">
    <ul class="table-view table-view2" id="onup">用户ID：<input name="openid" type="text"></ul>
    <ul class="table-view table-view2" id="onup">问题：<input name="notequestion" type="text"></ul>
    <ul class="table-view table-view2" id="onup">回复：<textarea name="notestr" cols="" rows="4"></textarea></ul>
    <ul class="table-view table-view2" id="onup"><input name="" type="submit" onClick="javascript:upnote();"></ul>
    </form>
   <!--content end--> 
   <script>
  function upnote() {
	  if(confirm("确认发送消息？"))
		  {
			document.noteform.submit();
		  }
  }
  </script>
 </body>
</html>