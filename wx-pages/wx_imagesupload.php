<?php
include 'includes/dbconfig.php';
$action = $_GET['act'];
if ($action == 'delimg') {
    $filename = $_POST['imagename'];
    $order_ID = $_POST['order_id'];
    $fag = $_POST['fag'];
    if ($fag == "first") {
        $images = $db->row_select('wx_order', 'order_ID=' . $order_ID, 1, 'fimages', 'order_ID');
        $image = $images[0]["fimages"];
        $imagearr = explode(";", $image);
        $str = "";
        if (!empty($imagearr)) {
            foreach ($imagearr as $u) {
                if ($u == $filename) {
                } else {
                    $str.= $u . ";";
                }
            }
            $str = substr($str, 0, strlen($str) - 1);
            $urow = array();
            $urow['fimages'] = $str;
            $row = $db->row_update("wx_order", $urow, "order_ID=" . $order_ID);
        }
    }
    if ($fag == "after") {
        $images = $db->row_select('wx_order', 'order_ID=' . $order_ID, 1, 'aimages', 'order_ID');
        $image = $images[0]["aimages"];
        $imagearr = explode(";", $image);
        $str = "";
        if (!empty($imagearr)) {
            foreach ($imagearr as $u) {
                if ($u == $filename) {
                } else {
                    $str.= $u . ";";
                }
            }
            $str = substr($str, 0, strlen($str) - 1);
            $urow = array();
            $urow['aimages'] = $str;
            $row = $db->row_update("wx_order", $urow, "order_ID=" . $order_ID);
        }
    }
    unlink('/wx-admin/uploads/' . $filename);
    echo '1';
}


if ($action == 'newimg') {
    $order_ID = $_GET['order_ID'];
    $fag = $_GET['fag'];
    if ($fag == "first") {
        $picname = $_FILES['mypic1']['name'];
        $picsize = $_FILES['mypic1']['size'];
    }
    if ($fag == "after") {
        $picname = $_FILES['mypic2']['name'];
        $picsize = $_FILES['mypic2']['size'];
    }
    if ($picname != "") {
        if ($picsize > 2048000) {
            echo '图片大小不能超过2M';
            exit;
        }
        $type = strstr($picname, '.');
        if ($type != ".gif" && $type != ".jpg") {
            echo '图片格式不对！';
            exit;
        }
        $rand = rand(100, 999);
        $pics = date("YmdHis") . $rand . $type;
        //上传路径
        $pic_path = "uploads/" . $pics;
        if ($fag == "first") {
            move_uploaded_file($_FILES['mypic1']['tmp_name'], $pic_path);
        }
        if ($fag == "after") {
            move_uploaded_file($_FILES['mypic2']['tmp_name'], $pic_path);
        }
    }
    $size = round($picsize / 1024, 2);
    $arr = array(
        'name' => $picname,
        'pic' => $pics,
        'size' => $size
    );
    //获取原有图片
    if ($fag == "first") {
        $images = $db->row_select('wx_order', 'order_ID=' . $order_ID, 1, 'fimages', 'order_ID');
        $image = $images[0]["fimages"];
        if (!empty($image)) $image.= ";";
        $urow = array();
        $urow['fimages'] = $image . $pics;
    }
    if ($fag == "after") {
        $images = $db->row_select('wx_order', 'order_ID=' . $order_ID, 1, 'aimages', 'order_ID');
        $image = $images[0]["aimages"];
        if (!empty($image)) $image.= ";";
        $urow = array();
        $urow['aimages'] = $image . $pics;
    }
    $row = $db->row_update("wx_order", $urow, "order_ID=" . $order_ID);
    echo json_encode($arr);
}
?>
