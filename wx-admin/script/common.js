$(function () {
        $(".topType").click(function () {
        var hasClass = $(this).hasClass("topTypeShow");
        if (hasClass) {
            $(".nav").stop(true, false).slideUp();
            $(this).removeClass("topTypeShow");
        }
        else {
            $(".nav").stop(true, true).slideDown();
            $(this).addClass("topTypeShow");
        }
    })
    $(".nav li:last").css("border-bottom", "none");


    //返回顶部按钮
    $('.backTop').click(function () {
        $("html,body").animate({ scrollTop: 0 }, 500);
        return false;
    });

//    //图片滚动
//    $('.caseImg').flexslider({
//        animation: 'slide',
//        controlNav: true,
//        directionNav: true,
//        animationLoop: true,
//        slideshow: false,
//        useCSS: false
//    });

//    var dSize2 = $(".caseImg .flex-control-paging li").size();
//    var ddW2 = $(".caseImg .flex-control-paging li:first").innerWidth() * dSize2;
//    $(".caseImg .flex-control-paging").css({ "width": ddW2 + 10, "margin-left": -ddW2 / 2 });



//    $(".caseImg .flex-control-paging li:first").attr("id", "first");
//    $(".caseImg .flex-control-paging li:last").attr("id", "last");
//    var leftBtn = "<img src='../images/else/z.png' width='100%' alt='' />";
//    var rightBtn = "<img src='../images/else/y.png' width='100%' alt='' />";
//    $(".caseImg .flex-direction-nav a.flex-prev").html(leftBtn);
//    $(".caseImg .flex-direction-nav a.flex-next").html(rightBtn);

})


////屏幕方向标识，0横屏，其他值竖屏
//var orientation=0;
////转屏事件，内部功能可以自定义
//function screenOrientationEvent(){
//    if(orientation == 0)document.getElementById("change").value="竖";
//    else document.getElementById("change").value="横";
//}
//var innerWidthTmp = window.innerWidth;
////横竖屏事件监听方法
//function screenOrientationListener(){
//    try{
//        var iw = window.innerWidth;     
//        //屏幕方向改变处理
//        if(iw != innerWidthTmp){
//            if(iw>window.innerHeight)orientation = 90;
//            else orientation = 0;
//            //调用转屏事件
//            screenOrientationEvent();
//            innerWidthTmp = iw;
//        }
//    } catch(e){};
//    //间隔固定事件检查是否转屏，默认500毫秒
//    setTimeout("screenOrientationListener()",500);
//}
////启动横竖屏事件监听
//screenOrientationListener();