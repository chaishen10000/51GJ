<?php
include 'includes/dbconfig.php';
include ('../wx-admin/includes/wx_message_class.php');
$action = $_GET['act'];
if (isset($_POST['openid']) && isset($_POST['uptype'])) {
    $uptype = $_POST['uptype'];
    $openid = $_POST['openid'];
    //新增物业或车辆
    if ($uptype == "new" && isset($_POST['type']) && isset($_POST['a']) && isset($_POST['b']) && isset($_POST['e']) && isset($_POST['f'])) {
        $user_meta = array(
            'type' => $_POST['type'],
            'openid' => $openid,
			'approved' => 0,
            'a' => $_POST['a'],
            'b' => $_POST['b'],
            'c' => $_POST['c'],
            'd' => $_POST['d'],
            'e' => $_POST['e'],
            'f' => $_POST['f'],
            'g' => $_POST['g'],
            'h' => $_POST['couponid']
        );
        $property_id = $db->row_insert('wx_property', $user_meta);
        if ($property_id > 0) {
			$smm = new template_message();
			$openid1 = "oN8WPs90EDEsJkdj8t-bBVukaD0o";
			$openid2 = "oN8WPs_DS8nApKcDwzqcmAuuscwo";
			$openid3 = "oN8WPs8kWI3zaX8ToMMF5brBjdGE";
			$openid4 = "oN8WPs26f6Rqt3ell6o0-A-UEmco";
			$smm->send_property_message($property_id,$openid1,date("Y-m-d H:i:s")."（提交）","物业登记",$_POST['e'],"请尽快电话跟进、审核");
			$smm->send_property_message($property_id,$openid2,date("Y-m-d H:i:s")."（提交）","物业登记",$_POST['e'],"请尽快电话跟进、审核");
			$smm->send_property_message($property_id,$openid3,date("Y-m-d H:i:s")."（提交）","物业登记",$_POST['e'],"请尽快电话跟进、审核");
			$smm->send_property_message($property_id,$openid4,date("Y-m-d H:i:s")."（提交）","物业登记",$_POST['e'],"请尽快电话跟进、审核");
            echo 'True';
        }
    }
    //更新物业或车辆
    if ($uptype == "update" && isset($_POST['a']) && isset($_POST['b']) && isset($_POST['e']) && isset($_POST['f'])) {
        $urow = array();
		$urow['approved'] = 0;
        $urow['a'] = $_POST['a'];
        $urow['b'] = $_POST['b'];
        $urow['c'] = $_POST['c'];
        $urow['d'] = $_POST['d'];
        $urow['e'] = $_POST['e'];
        $urow['f'] = $_POST['f'];
		if (isset($_POST['g'])) {
            $urow['g'] = $_POST['g'];
        }
        if (isset($_POST['h'])) {
            $urow['h'] = $_POST['couponid'];
        }
		$property_ID = $_POST['property_ID'];
        $row = $db->row_update("wx_property", $urow, "property_ID=" . $property_ID);
        if ($row) {
            echo 'True';
        }
    }
}
//删除物业或车辆
if ($action == 'property_del') {
    $propertyID = $_POST['propertyID'];
    if (!empty($propertyID)) {
		//未完工：删除图片操作
        $user_meta = "property_ID = " . $propertyID;
        if ($db->row_delete('wx_property', $user_meta)) {
			$smm = new template_message();
			$openid1 = "oN8WPs90EDEsJkdj8t-bBVukaD0o";
			$openid2 = "oN8WPs_DS8nApKcDwzqcmAuuscwo";
			$openid3 = "oN8WPs8kWI3zaX8ToMMF5brBjdGE";
			$openid4 = "oN8WPs26f6Rqt3ell6o0-A-UEmco";
			$smm->send_property_message($property_id,$openid1,date("Y-m-d H:i:s")."（提交）","物业删除","删除记录","请安排相关人员跟进后续工作");
			$smm->send_property_message($property_id,$openid1,date("Y-m-d H:i:s")."（提交）","物业删除","删除记录","请安排相关人员跟进后续工作");
			$smm->send_property_message($property_id,$openid1,date("Y-m-d H:i:s")."（提交）","物业删除","删除记录","请安排相关人员跟进后续工作");
			$smm->send_property_message($property_id,$openid1,date("Y-m-d H:i:s")."（提交）","物业删除","删除记录","请安排相关人员跟进后续工作");
            echo '1';
        } else {
            echo '删除失败。';
        }
    } else {
        echo '删除失败。';
    }
}

//删除图片
/*if ($action == 'delimg') {
    $filename = $_POST['imagename'];
    if (!empty($filename)) {
        unlink('uploads/' . $filename);
        echo '1';
    } else {
        echo '删除失败.';
    }
} */

/**从微信JSSDK中拉取图片存放本地服务器
请开启PHP的扩展
extension=php_curl.dll
extension=php_openssl.dll
access_token 是公众号的全局唯一票据，公众号调用各接口时都需使用access_token。
开发者需要进行妥善保存。access_token的存储至少要保留512个字符空间。
access_token的有效期目前为2个小时，需定时刷新，重复获取将导致上次获取的access_token失效。
media_id 来自微信内页传过来的自定义参数
**/
if ($action == 'newimg') {
	$media_id = $_GET['media_id'];
	$accesstoken = $_GET['accesstoken'];
	$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$accesstoken."&media_id=".$media_id;
	$return_content = http_get_data($url); 
	if(strlen($return_content)>1000){
		$rand = rand(100, 999); 
		$filename = date("Ymdhis").$rand.".jpg";
		$fileurl = "uploads/".$filename;
		$fp= @fopen($fileurl,"a"); //将文件绑定到流
		fwrite($fp,$return_content); //写入文件  
		fclose($fp);  //关闭文件流
		echo trim($filename);  //可以输出信息返回给微信内页处理
	}else{
		echo "error";
	}
}

//房产认证
if ($action == 'approvedup') {
	$urow['approved'] = $_POST['approved'];
	$property_ID = $_POST['property_ID'];
	$row = $db->row_update("wx_property", $urow, "property_ID=" . $property_ID);
	if ($row) {
            echo 'True';
    }
}

function http_get_data($url) {    
		$ch = curl_init ();  
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );  
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );  
		curl_setopt ( $ch, CURLOPT_URL, $url );  
		ob_start ();  
		curl_exec ( $ch );  
		$return_content = ob_get_contents (); 
		//获取长度
		$return_length = ob_get_length();
		ob_end_clean ();  
		  
		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );  
		return $return_content;  
	} 