<?php
include 'includes/dbconfig.php';
include 'includes/wx_message_class.php';
if (isset($_POST['third_part_fee'])&&isset($_POST['order_ID'])&&isset($_POST['openid'])) {
    $user_meta = array('third_part_fee' => $_POST['third_part_fee']);
	//车管家、生活管家不扣款
    if ($_POST['type'] == "车管家" || $_POST['type'] == "生活管家") {
		$user_meta['state'] = '已提交';
		$order_ID = $_POST['order_ID'];
		
		$row = $db->row_select('wp_users', 'openid=\'' . $_POST['openid'] . '\'', 1, 'user_cash,total_consumer', 'ID');
        foreach ($row as $key => $value) {
            $user_cash1 = $value['user_cash'];
            $total_consumer = $value['total_consumer'];
        }
        //扣款操作
        $user_cash = (int) $user_cash1 - (int) $_POST['third_part_fee'] - (int) $_POST['$total_fee1'] ;
        if ($user_cash >= 0) {
            $urow = array();
            $urow['user_cash'] = $user_cash;
            $urow['total_consumer'] = $total_consumer + (int) $_POST['third_part_fee']+ (int) $_POST['$total_fee1'];
			//生成订单记录
            $row = $db->row_update('wx_order', $user_meta ,'order_ID=' . $order_ID);
            if ($row) {
				//更新账户余额
                $row = $db->row_update('wp_users', $urow, 'openid=\'' . $_POST['openid'] . '\'');
                if ($row) {
                    echo 'True:' . $order_ID;
                }
            } else {
                echo '未知错误:0';
            }
        } else {
            echo '余额不足:0';
        }
    } else {
        echo "服务项目错误:0";
    }
} else {
    echo '参数错误:0';
}

        