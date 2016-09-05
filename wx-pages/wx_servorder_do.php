<?php
include 'includes/dbconfig.php';
if (isset($_POST['time_serv']) && isset($_POST['property_ID']) && isset($_POST['openid']) && isset($_POST['type']) && isset($_POST['service']) && isset($_POST['total_fee']) && isset($_POST['cash_fee'])) {
    $user_meta = array('openid' => $_POST['openid'], 'property_ID' => $_POST['property_ID'], 'type' => $_POST['type'], 'state' => '已提交', 'time_up' => time(), 'service' => $_POST['service'], 'time_serv' => $_POST['time_serv'], 'remarks' => $_POST['remarks'], 'total_fee' => $_POST['total_fee'], 'cash_fee' => $_POST['cash_fee'], 'service_progress' => 0);
    if ($_POST['type'] == "房管家") {
        $period = $_POST['period'];
        $frequency = $_POST['frequency'];
        $user_meta['service_detail'] = $period . ":" . $frequency;
    }
	//车管家、生活管家不扣款
    if ($_POST['type'] == "车管家" || $_POST['type'] == "生活管家") {
		$order_id = $db->row_insert('wx_order', $user_meta);
		if ($order_id > 0) {
            echo 'True:' . $order_id;
		}
    } else {
        //账户金额操作
        $row = $db->row_select('wp_users', 'openid=\'' . $_POST['openid'] . '\'', 1, 'user_cash,total_consumer', 'ID');
        foreach ($row as $key => $value) {
            $user_cash1 = $value['user_cash'];
            $total_consumer = $value['total_consumer'];
        }
        //扣款操作
        $user_cash = (int) $user_cash1 - (int) $_POST['cash_fee'];
        if ($user_cash >= 0) {
            $urow = array();
            $urow['user_cash'] = $user_cash;
            $urow['total_consumer'] = $total_consumer + (int) $_POST['cash_fee'];
			//生成订单记录
            $order_id = $db->row_insert('wx_order', $user_meta);
            if ($order_id > 0) {
				//更新账户余额
                $row = $db->row_update('wp_users', $urow, 'openid=\'' . $_POST['openid'] . '\'');
                if ($row) {
                    echo 'True:' . $order_id;
                }
            } else {
                echo '未知错误:0';
            }
        } else {
            echo '余额不足:0';
        }
    }
} else {
    echo '参数错误:0';
}