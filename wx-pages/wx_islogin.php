<?php
include 'includes/dbconfig.php';
global $wp_hasher;
if (empty($wp_hasher)) {
    require_once '../wp-includes/class-phpass.php';
    $wp_hasher = new PasswordHash(8, TRUE);
}

session_start();
$geturl = $_SERVER['HTTP_REFERER'];
$testurl = strstr($geturl,'http://www.weigj.cn/');
if(strlen($testurl)>0){
	$_SESSION['geturl'] = $geturl;
}
if (!isset($_GET['code'])) {
	header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb9ac015082f7fd23&redirect_uri=http://www.weigj.cn/wx-pages/wx_islogin.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect");
}else{
	$url1 = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxb9ac015082f7fd23&secret=6c796e09961188ff62a8d1a48d507d22&code=' . $_GET['code'] . '&grant_type=authorization_code';
    $json_string1 = https_request($url1);
    $obj1 = json_decode($json_string1, true);
	$openid = $obj1['openid'];
	
    $url2 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $obj1['access_token'] . '&openid=' . $openid;
    $json_string2 = https_request($url2);
    // echo '<br/><hr/>';
    $obj2 = json_decode($json_string2, true);
    //echo $obj2['sex'];
    //echo $obj2['language'];
    //echo $obj2['city'];
    //echo $obj2['country'];
    //echo $obj2['headimgurl'];
    //echo $obj2['privilege'];
	$openid = $obj1['openid'];
	$row = $db->row_select("wp_users", "openid='" . $openid . "'", 1, 'ID', 'ID');
	if (count($row)>0) {
		$_SESSION['openid'] = $openid;
		$urow = array();
        $urow['user_url'] = $obj2['headimgurl'];
		$row = $db->row_update("wp_users", $urow, "openid='" . $openid . "'");
	    echo "<script>url='".$_SESSION['geturl']."';window.location.href=url;</script>"; 
	   }else{
	   if (!empty($obj2['nickname'])) {
			  $user_meta = array('user_login' => $obj2['nickname'], 'user_pass' => $wp_hasher->HashPassword($openid), 'display_name' => $obj2['nickname'], 'user_nicename' => $obj2['nickname'], 'user_url' => $obj2['headimgurl'], 'user_email' => 'wx_' . rand() . '@qq.com', 'openid' => $openid);
			  $user_id = $db->row_insert('wp_users', $user_meta);
			  
			  $user_meta = array('user_id' => $user_id, 'meta_key' => 'wx_user_avatar', 'meta_value' => $obj2['headimgurl']);
			  $db->row_insert('wp_usermeta', $user_meta);
			  $user_meta = array('user_id' => $user_id, 'meta_key' => 'wx_sex', 'meta_value' => $obj2['sex']);
			  $db->row_insert('wp_usermeta', $user_meta);
			  $user_meta = array('user_id' => $user_id, 'meta_key' => 'wx_city', 'meta_value' => $obj2['city']);
			  $db->row_insert('wp_usermeta', $user_meta);
			  $user_meta = array('user_id' => $user_id, 'meta_key' => 'nickname', 'meta_value' => $obj2['nickname']);
			  $db->row_insert('wp_usermeta', $user_meta);
			  $user_meta = array('user_id' => $user_id, 'meta_key' => 'wp_user_level', 'meta_value' => 1);
			  $db->row_insert('wp_usermeta', $user_meta);
			  $user_meta = array('user_id' => $user_id, 'meta_key' => 'wp_capabilities', 'meta_value' => 'a:1:{s:11:"contributor";b:1;}');
			  $db->row_insert('wp_usermeta', $user_meta);
			  session_start();
			  $_SESSION['user_id'] = $user_id;
			  $_SESSION['user_login'] = $obj2['nickname'];
			  $_SESSION['openid'] = $openid;
			  echo "<script>alert('您是新用户，请先完善信息！');url='/wx-pages/mypage.php';window.location.href=url;</script>"; 
	    }
	}
}

function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>