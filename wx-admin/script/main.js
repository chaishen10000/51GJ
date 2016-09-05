requirejs(["ratchet", "xiaoma"], function(ratchet, XM){
    require(["swipe"], function(){
        var swipes = $('#mySwipe .swipe-wrap > div');
        if(swipes.length > 0) {
            if(swipes.length == 1) $(".slider-dots").hide();
            var continuous = true;
            if(swipes.length < 3) continuous = false;
            window.mySwipe = Swipe(document.getElementById('mySwipe'), {
                startSlide: 0,
                continuous: continuous,
                disableScroll: false,
                stopPropagation: true,
                auto:5000,
                callback: function(index, elem) {
                    $(".slider-dots .cur").removeClass("cur");
                    $(".slider-dots span").eq(index).addClass("cur");
                }
            });
        }
    });

    var tabIndex = $('.tab[data-tab]').data('tab');
    $('.tab .tab-item').on('tap', function(){
        var $this   = $(this);
        var index   = $this.index();
        var $parent = $this.parents('.tab');
        $parent
            .find('.tab-loading')
            .remove();

        $parent
            .find('.tab-item')
            .removeClass('active2')
            .find('input')
            .removeAttr('checked');

        $parent
            .find('.tab-cnt')
            .hide()
            .eq(index).show();

        $this.addClass('active2');
        $this.find('input').attr('checked', 'checked');
    }).eq(tabIndex).trigger('tap');

    //选择服务时间弹层
    XM.order.bindTimeDlg({ clazz: "order-dlg" });

    XM.order.bindTickectDlg({
        title: "请点击选择优惠券",
        callback: function(){
            var id = $('#tickets-sel').val();
            XM.order.selectOrderTickets(id);
            $('#couponid').val($('#tickets-sel').val());
            window.selCoupons && selCoupons();
        }
    }, function(){
        var value     = $('#tickets-sel').val();
        var valueText = $('#tickets-sel option:selected').text();
        $('#couponid').val(value);
        $('#syyhq').html(valueText);
    });
});



