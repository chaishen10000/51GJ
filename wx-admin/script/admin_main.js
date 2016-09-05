$(document).ready(function() {

    //订单状态修改
    $(".sstate").change(function() {
        var state = $(this).val();
        var id = $(this).data("id");
        if (confirm("确认修改？")) {
            $.ajax({ //请求登录处理页
                url: "/wx-admin/orderstate_do.php?type=state",
                //处理页
                type: "POST",
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                dataType: "text",
                //传送请求数据
                data: {
                    state: state,
                    order_ID: id
                },
                success: function(data) { //登录成功后返回的数据
				    //alert(data);
                    if ($.trim(data) == "True") {
                        alert("修改成功！");
                        $("#state" + id).html(state);
                    }
                },
                error: function(data) {
                    alert("修改不成功！" + data);
                }
            });
            return false;
        }
    });

    //订单状态修改END
	
    //分配执行人员
    $(".sworker").change(function() {
        var worker = $(this).val();
        var id = $(this).data("id");
		var cname = $(this).data("cname");
		var assign = $(this).data("cuser");
        if (confirm("确认分配？")) {
            $.ajax({ //请求登录处理页
                url: "/wx-admin/orderstate_do.php?type=worker",
                //处理页
                type: "POST",
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                dataType: "text",
                //传送请求数据
                data: {
					assign: assign,
                    worker: worker,
                    order_ID: id
                },
                success: function(data) { //登录成功后返回的数据
				    //alert(data);
                    if ($.trim(data) == "True") {
                        alert("分配成功！");
						$("#assign" + id).html(cname);
                    }
                },
                error: function(data) {
                    alert("分配不成功！" + data);
                }
            });
            return false;
        }
    });
    //分配执行人员 END
	
	//图片上传	
	var bar = $('.imagup_bar');
    var percent = $('.imagup_percent');
    var showimges = $('#showimges');
    var progress = $(".imagup_progress");
    var files = $(".imagup_files");
    var btn1 = $(".imagup_btn1 span");
	var btn2 = $(".imagup_btn2 span");
    var order_ID = $("#order_ID").val();
	files.hide();
    $("#fileupload1").wrap("<form id='myupload1' action='/wx-admin/imagesupload.php?act=newimg&fag=first&order_ID="+order_ID+"' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload1").change(function() {
        $("#myupload1").ajaxSubmit({
            dataType: 'json',
            beforeSend: function() {
                showimges.empty();
                progress.show();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
                btn1.html("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function(data) {
				files.show();
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <div class='imagup_delimg' data-fag='first' data-id="+order_ID+" rel='" + data.pic + "'>删除</div>");
                var img = "/wx-admin/uploads/" + data.pic;
                showimges.html("<img src='" + img + "' width='100%'>");
                //$("#g").val(img);
				window.location.reload();//刷新当前页面
                btn1.html("添加图片");
            },
            error: function(xhr) {
                btn1.html("上传失败");
                bar.width("0");
				files.show();
                files.html(xhr.responseText);
            }
        });
    });

    $("#fileupload2").wrap("<form id='myupload2' action='/wx-admin/imagesupload.php?act=newimg&fag=after&order_ID="+order_ID+"' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload2").change(function() {
        $("#myupload2").ajaxSubmit({
            dataType: 'json',
            beforeSend: function() {
                showimges.empty();
                progress.show();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
                btn2.html("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function(data) {
				files.show();
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <div class='imagup_delimg' data-fag='after' data-id="+order_ID+" rel='" + data.pic + "'>删除</div>");
                var img = "/wx-admin/uploads/" + data.pic;
				showimges.show();
                showimges.html("<img src='" + img + "' width='100%'>");
                //$("#g").val(img);
				window.location.reload();//刷新当前页面.
                btn2.html("添加附件");
            },
            error: function(xhr) {
                btn2.html("上传失败");
                bar.width("0");
				files.show();
                files.html(xhr.responseText);
            }
        });
    });

    $(".imagup_delimg").live('click', function() {
        var pic = $(this).attr("rel");
		var picstr = pic.substring(0,pic.length-4);
		var id = $(this).data("id");
		var fag = $(this).data("fag");
        $.post("/wx-admin/imagesupload.php?act=delimg", {
            imagename: pic,
			order_id: id,
			fag: fag
        }, function(msg) {
            if (msg == 1) {
                files.html("删除成功.");
				$("#show"+picstr).hide();
                progress.hide();
            } else {
                alert(msg);
            }
        });
    });
	
	//订单详情
	$('.in_out_event .orderid').click(function(){
		$('.theme-popover-mask').fadeIn(100);
		$('.theme-popover').slideDown(200);
		var orderid = $(this).data('id');
		$(".theme-poptit h3").html("订单#"+orderid+"详情");
		$("#orderframe").attr("src","http://www.weigj.cn/wx-admin/orderdetail2.php?order_ID="+orderid);
	});
	$('.theme-poptit .close').click(function(){
		$('.theme-popover-mask').fadeOut(100);
		$('.theme-popover').slideUp(200);
	});
	
});