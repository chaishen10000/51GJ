<?php
include 'includes/dbconfig.php';
session_start();
$geturl = $_SERVER['HTTP_REFERER'];
$testurl = strstr($geturl,'http://www.weigj.cn/');
if(strlen($testurl)>0){
	$_SESSION['geturl'] = $geturl;
}
if (!isset($_GET['code'])) {
	header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb9ac015082f7fd23&redirect_uri=http://www.weigj.cn/wx-admin/islogin.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect");
}else{
	$url1 = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxb9ac015082f7fd23&secret=6c796e09961188ff62a8d1a48d507d22&code=' . $_GET['code'] . '&grant_type=authorization_code';
    $json_string1 = https_request($url1);
    $obj1 = json_decode($json_string1, true);
	$openid = $obj1['openid'];
	$row = $db->row_select("wp_users", "openid='" . $openid . "'", 1, 'ID', 'ID');
	if (count($row)>0) {
		$_SESSION['openid'] = $openid;
		$row = $db->row_select("wp_usermeta", "meta_key = 'wp_user_level' and user_id=" . $row[0]["ID"]  , 1, 'meta_value', 'umeta_id');
		if (count($row)>0) {
			$user_level = $row[0]["meta_value"];
			$_SESSION['user_level'] = $user_level;
			if($user_level>=2){
				echo "<script>url='".$_SESSION['geturl']."';window.location.href=url;</script>"; 
			}
		}
	}
}
echo "<script>alert('非法访问！');window.location.href=/wx-pages/;</script>"; 
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