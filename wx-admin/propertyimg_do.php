<?php
include 'includes/dbconfig.php';
$action = $_GET['act'];

//删除图片
if ($action == 'delimg') {
    $filename = $_POST['imagename'];
    $property_ID = $_POST['property_ID'];
    $fag = $_POST['fag'];
    echo delimg($property_ID,$fag,$filename,$db);
}

function delimg($property_ID,$fag,$filename,$db){
	$images = $db->row_select('wx_property', 'property_ID=' . $property_ID, 1, $fag, 'property_ID');
	$image = $images[0][$fag];
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
		$urow[$fag] = $str;
		$row = $db->row_update("wx_property", $urow, "property_ID=" . $property_ID);
	}
	unlink('/wx-admin/uploads/' . $filename);
	return '1';
}

//添加图片
if ($action == 'newimg') {
    $property_ID = $_GET['property_ID'];
    $fag = $_GET['fag'];
	if($fag == "images1") $mypic = "mypic1";
	if($fag == "images2") $mypic = "mypic2";
	if($fag == "images3") $mypic = "mypic3";
	if($fag == "images4") $mypic = "mypic4";
	
	echo newimg($property_ID,$fag,$mypic,$db);
}

function newimg($property_ID,$fag,$mypic,$db){

	$picname = $_FILES[$mypic]['name'];
	$picsize = $_FILES[$mypic]['size'];

    if ($picname != "") {
        if ($picsize > 2048000) {
            echo '图片大小不能超过2M';
            exit;
        }
        $type = strstr($picname, '.');
        if ($type != ".gif" && $type != ".jpg" && $type != ".jpeg" && $type != ".png") {
            echo '图片格式不对！';
            exit;
        }
        $rand = rand(100, 999);
        $pics = date("YmdHis") . $rand . $type;
        //上传路径
        $pic_path = "uploads/" . $pics;

        move_uploaded_file($_FILES[$mypic]['tmp_name'], $pic_path);
        
    }
    $size = round($picsize / 1024, 2);
    $arr = array(
        'name' => $picname,
        'pic' => $pics,
        'size' => $size
    );
    //获取原有图片
	$images = $db->row_select('wx_property', 'property_ID=' . $property_ID, 1, $fag, 'property_ID');
	$image = $images[0][$fag];
	if (!empty($image)) $image.= ";";
	$urow = array();
	$urow[$fag] = $image . $pics;
    
    $row = $db->row_update("wx_property", $urow, "property_ID=" . $property_ID);
    return json_encode($arr);
}
?>
