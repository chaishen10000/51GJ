(function(){
    _.templateSettings = {
        evaluate: /\{\{([\s\S]+?)\}\}/g,
        interpolate: /\{\{=([\s\S]+?)\}\}/g,
        escape: /\{\{-([\s\S]+?)\}\}/g
    };
    $.fn.dlg = function(options){
        var setting = $.extend({
            'clazz'  : '',
            'content': '',
            'title'  : '',
            'mask'   : 1,
            'clazz'  : '',
            'btns'   : '<button class="dlg-btn" dlg-act="cancel">取消</button> <button class="dlg-btn" dlg-act="done">完成</button>',
            'tpl'    : '{{if(mask){}} <div class="mask"></div> {{}}} <div class="dlg {{=clazz}}"> <div class="dlg-tle"> {{=btns}} <h5>{{=title}}</h5> </div> <div class="dlg-wp"> {{=content}} </div> </div>',
            'z-index': 1000,
            'closeCall': null,
            'callback': null
        }, options);
        //var $content = $('.content, body > .bar');
        var _scrollY = 0;
        function dlgCls(e, modal, call){
            e.preventDefault();
            modal.removeClass('active');
            setting[call] && setting[call].call(modal);
            setTimeout(function(){
                modal.remove();
                $('.mask').remove();
            }, 200);
        }
        return this.each(function(){
            _scrollY = window.scrollY;
            //$content.hide();
            var modal = $(this).html($(_.template(setting.tpl)(setting)));
            modal.attr('dlg-type', 'dlg')
                .appendTo('body')
                .find('.dlg-btn[dlg-act="cancel"]')
                .on('click', function(e){
                    dlgCls(e, modal, 'closeCall');
                });
            modal
                .find('.dlg-btn[dlg-act="done"]')
                .on('click', function(e){
                    dlgCls(e, modal, 'callback');
                });
            setTimeout(function(){
                modal.addClass('active');
            }, 100);
            return this;
        });
    };
})(Zepto);



