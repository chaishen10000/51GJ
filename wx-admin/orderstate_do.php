<?php
session_start();
if ($_SESSION['user_level'] <7 ) {
	//网页端后台
	echo "<script>window.location.href='/wp-admin/';</script>";
}else{
include 'includes/dbconfig.php';
include 'includes/wx_message_class.php';
if ($_GET['type'] == 'state') {
    if (isset($_POST['state']) && isset($_POST['order_ID'])) {
        $urow = array();
        $urow['state'] = $_POST['state'];
        $order_ID = (int) $_POST['order_ID'];
        $row = $db->row_update('wx_order', $urow, 'order_ID=' . $order_ID);
        if ($row) {
            echo 'True';
        }
    }
}

if ($_GET['type'] == 'worker') {
    if (isset($_POST['worker']) && isset($_POST['assign']) && isset($_POST['order_ID'])) {
        $urow = array();
        $urow['worker'] = $_POST['worker'];
		$urow['assign'] = $_POST['assign'];
        $order_ID = (int) $_POST['order_ID'];
        $row = $db->row_update('wx_order', $urow, 'order_ID=' . $order_ID);
        if ($row) {
			//执行人信息
			$workers = $db->row_select('wp_users', 'ID='.$_POST['worker'], 1, 'openid,user_nicename', 'ID');
			$openid = $workers[0]["openid"];
			$worker_nicename = $workers[0]["user_nicename"];
			//分配人信息
			$assigns = $db->row_select('wp_users', 'ID='.$_POST['assign'], 1, 'user_nicename', 'ID');
			$assign_nicename = $assigns[0]["user_nicename"];
			//订单信息
			$orders = $db->row_select('wx_order', 'order_ID='.$order_ID, 1, 'property_ID,type', 'order_ID');
			$property_ID = $orders[0]["property_ID"];
			$type = $orders[0]["type"];
			//物业信息
			$propertys = $db->row_select('wx_property', 'property_ID='.$property_ID, 1, 'e', 'property_ID');
			$property_address = $propertys[0]["e"];
			$swm = new template_message();
			$swm->send_worker_message($order_ID,$openid,$worker_nicename,$assign_nicename,$type,$property_address);
			echo 'True';
        }
    }
}
}