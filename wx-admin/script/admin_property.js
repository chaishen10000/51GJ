$(document).ready(function() {
	
	//图片上传	
	var bar = $('.imagup_bar');
    var percent = $('.imagup_percent');
    var showimges = $('#showimges');
    var progress = $(".imagup_progress");
    var files = $(".imagup_files");
    var btn1 = $(".imagup_btn1 span");
	var btn2 = $(".imagup_btn2 span");
	var btn3 = $(".imagup_btn3 span");
	var btn4 = $(".imagup_btn4 span");
    var property_ID = $("#property_ID").val();
	files.hide();
    $("#fileupload1").wrap("<form id='myupload1' action='/wx-admin/propertyimg_do.php?act=newimg&fag=images1&property_ID="+property_ID+"' method='post' enctype='multipart/form-data'></form>");
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
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <div class='imagup_delimg' data-fag='images1' data-id="+property_ID+" rel='" + data.pic + "'>删除</div>");
                var img = "/wx-admin/uploads/" + data.pic;
                showimges.html("<img src='" + img + "' width='100%'>");
				window.location.reload();//刷新当前页面
                btn1.html("添加图片");
            },
            error: function(xhr) {
                btn1.html(xhr.responseText);
                bar.width("0");
                files.html(xhr.responseText);
            }
        });
    });

    $("#fileupload2").wrap("<form id='myupload2' action='/wx-admin/propertyimg_do.php?act=newimg&fag=images2&property_ID="+property_ID+"' method='post' enctype='multipart/form-data'></form>");
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
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <div class='imagup_delimg' data-fag='images2' data-id="+property_ID+" rel='" + data.pic + "'>删除</div>");
                var img = "/wx-admin/uploads/" + data.pic;
				showimges.show();
                showimges.html("<img src='" + img + "' width='100%'>");
				window.location.reload();//刷新当前页面.
                btn2.html("添加附件");
            },
            error: function(xhr) {
                btn2.html("上传失败");
                bar.width("0");
                files.html(xhr.responseText);
            }
        });
    });
    
	$("#fileupload3").wrap("<form id='myupload3' action='/wx-admin/propertyimg_do.php?act=newimg&fag=images3&property_ID="+property_ID+"' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload3").change(function() {
        $("#myupload3").ajaxSubmit({
            dataType: 'json',
            beforeSend: function() {
                showimges.empty();
                progress.show();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
                btn3.html("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function(data) {
				files.show();
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <div class='imagup_delimg' data-fag='images3' data-id="+property_ID+" rel='" + data.pic + "'>删除</div>");
                var img = "/wx-admin/uploads/" + data.pic;
				showimges.show();
                showimges.html("<img src='" + img + "' width='100%'>");
				window.location.reload();//刷新当前页面.
                btn3.html("添加附件");
            },
            error: function(xhr) {
                btn3.html("上传失败");
                bar.width("0");
                files.html(xhr.responseText);
            }
        });
    });
	
	$("#fileupload4").wrap("<form id='myupload4' action='/wx-admin/propertyimg_do.php?act=newimg&fag=images4&property_ID="+property_ID+"' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload4").change(function() {
        $("#myupload4").ajaxSubmit({
            dataType: 'json',
            beforeSend: function() {
                showimges.empty();
                progress.show();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
                btn4.html("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function(data) {
				files.show();
                files.html("<b>" + data.name + "(" + data.size + "k)</b> <div class='imagup_delimg' data-fag='images4' data-id="+property_ID+" rel='" + data.pic + "'>删除</div>");
                var img = "/wx-admin/uploads/" + data.pic;
				showimges.show();
                showimges.html("<img src='" + img + "' width='100%'>");
				window.location.reload();//刷新当前页面.
                btn4.html("添加附件");
            },
            error: function(xhr) {
                btn4.html("上传失败");
                bar.width("0");
                files.html(xhr.responseText);
            }
        });
    });


    $(".imagup_delimg").live('click', function() {
        var pic = $(this).attr("rel");
		var picstr = pic.substring(0,pic.length-4);
		var id = $(this).data("id");
		var fag = $(this).data("fag");
        $.post("/wx-admin/propertyimg_do.php?act=delimg", {
            imagename: pic,
			property_ID: id,
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
	
});