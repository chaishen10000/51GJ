define(["dialog","iscroll"], function(){
    var XM = window.XM || {};
    XM.vertion = "1.0.0";
    XM.util = {
        tips: function(msg, loading, delay){
            var that = this;
            var delayTime = 1500;
            var loading = loading ? '<s class="loading20 inline-blk"></s>' : '';
            $('body').append('<div class="loading-dlg"><div class="mask"></div><div class="loading-dlg-inner">'+loading+msg+'</div></div>');
            if(delay) {
                setTimeout(function(){
                    that.removeTip();
                }, delayTime);
            }
        },
        removeTip: function(){
            $('.loading-dlg').remove();
        }
    };
    XM.order = $.extend(XM.order||{}, {
        bindTickectDlg: function(opts, callback){
            var _this = this;
            var _html = $('#orderTicketTpl').html();
            var _tpl  = _html && _.template(_html);
            if(!_tpl) return;
            this.wrap
                .on('click', '[data-act="dlg-ticket"]', function(e){
                    e.preventDefault();
                    var _opts = $.extend({
                        'content': _tpl({"lists": _this.ticktes})
                    }, opts);
                    $('<div></div>').dlg(_opts);
                    if(typeof callback == "function") callback.call(_this);
                });
        },
        orderDlgCloseCall: function(){
            var $time    = this.$timeInput;
            var $qxzfwsj = this.$qxzfwsj;
            var defaultOrderTime = $qxzfwsj.html();
            //关闭时间弹窗callback
            if(this.activeTime && this.dateActiveIndex >= 0) {
                //$('#qxzfwsj').html();
                var index = this.dateActiveIndex;
                var date  = XM.order.times['dates'][index];
                var value = date['full_date'] + ' (' + date['week'] + ') ' + this.activeTime;
                $time.val(value);
                $qxzfwsj.html(value);
                //$time.data('origin-value',  )
                XM.order.reset('#time');
                return;
            }
            $qxzfwsj.html(defaultOrderTime);
        },
        bindTimeDlg: function(opts, callback){
            var that            = this;
            var orderTimeTpl    = this.orderTimeTpl;
            var orderTimeSelTpl = this.orderTimeSelTpl;
            if(!orderTimeTpl || !orderTimeSelTpl) return;
            this.wrap
                .on('click', '[data-act="dlg-time"]', function(e){
                    e.preventDefault();
                    if(!that.validate()) return;
                    XM.util.tips('服务时间获取中',1);
                    that.$timeInput.trigger('__focus');
                    that.fetchTimeList(function(){
                        var orderTimes      = XM.order.times;
                        var _html  = _.template(orderTimeTpl)(orderTimes);
                        var _opts = $.extend({
                            'content': _html
                        }, opts);
                        that.orderTimeDlg = $('<div></div>').dlg(_opts);
                        XM.util.removeTip();
                        that.setup(orderTimes);
                        if(typeof callback == "function") callback.call(that);
                        that.orderDlgClose(that.orderDlgCloseCall);
                    });
                });
        },
        validate: function(){
            var msg = '';
            var ret = true;
            var data = XM.butler.data;
            var addr = $.trim($(data['address']).val());
            var type = $.trim($(data['units']).val());
            /*if(!addr) {
                XM.util.tips('请输入服务地址', 0, 1);
                return false;
            }*/
            if(!type) {
                XM.util.tips('请选择服务类型', 0, 1);
                return false;
            }
            return true;
        },
        fetchTimeList: window.loadAvailableTimeList,
        setup: function(orderTimes){
            this.$scroller       = $("#order-scroller");
            this.$scrollerInner  = $(".order-time-scroller");
            this.$orderTimeSelWp = $("#orderTimeSelWp");
            var $scroller    = this.$scroller;
            var $el          = $scroller.find('li');
            var length       = $el.length;
            var _scrollWidth = $el.width() * length;
            var activeIndex  = this.dateActiveIndex;
            var $liEl        = $scroller.find('li');
            var $active      = $liEl.filter('[data-index="'+activeIndex+'"]');
            var index        = 0;
            $active          = (!$active.length) ? $liEl.filter('[data-state="0"]').eq(0):$active;
            this.initActiveIndex = this.initActiveIndex || $active;
            index            = $active.data('index');
            $active.addClass('active');

            this.dateActiveIndex = index;
            this.scrollWidth     = _scrollWidth;
            this.clientWidth     = $scroller.width();

            $el.width($el.width());
            this.$scrollerInner.width(_scrollWidth)
                .find('.order-row').each(function(i, row){
                var $row = $(row);
                var $li  = $(row).find('li');
                var _width = $li.width() * $li.length;
                $row.width(_width);
            });
            this.$orderTimeSelWp.html( _.template(this.orderTimeSelTpl)( { "date": orderTimes['dates'][index]} ));
            //初始化滚动
            this.initScroll();
        },
        bindTimeChangeEvt: function(callback, changeCallback){
            var _this     = this;
            var _tpl      = '{{_.each(dates[index].hours, function(hour){ }} <option data-value="{{=hour}}" value="{{=dates[index].date}}/{{=hour}}">{{=hour}}</option> {{ }) }}';
            _this.$dateSel  = $('#date-sel');
            _this.$hoursSel = $('#hours-sel');
            if(typeof callback == "function") callback.call(_this);
            _this.$dateSel.unbind().bind('change', function(){
                var index    = $(this.options[this.selectedIndex]).data('index');
                var _options = _.template(_tpl)({dates: _this.times.dates, selected: _this.times.selected,index: index});
                _this.$hoursSel.html(_options);
                if(typeof changeCallback == "function") changeCallback.call(_this);
            });
        },
        selectOrderTickets: function(id){
            id = id || 0;
            this.ticktes.selected = id;
        },
        orderDlgClose: function(callback){
            var that = this;
            that.orderTimeDlg.find('[data-act="dlg-hide"], .mask').unbind('click').on('click', function(){
                $(this).parents('.active').remove();
                if(callback) callback.call(that);
            });
        },
        scrollToSelectTimePosition: function(){
            var $el   = this.$scroller.find('.active');
            var index = $el.data('index');
            var x     = $el.position().left;
            if(this.scrollWidth <= this.clientWidth + x) {
                x = this.scrollWidth - this.clientWidth;
            }
            this.myScroll.scrollTo(-x, 0);
        },
        initScroll: function(){
            this.myScroll = new IScroll('#order-scroller', { scrollX: true});
            this.$orderTimeSelWp.find('li[data-time="'+this.activeTime+'"]').addClass('active');
            this.scrollToSelectTimePosition();
        },
        cancleOrderTime: function(){
            this.$timeInput.val('');
            this.$qxzfwsj.text(this.defaultTimeText);
            this.dateActiveIndex = '';
            this.activeTime = '';
        },
        bindEvt: function(){
            var that = this;
            this.wrap.on('tap', '#orderTimeSelWp .order-time-item li',function(){
                var $this = $(this);
                var state = $this.data('state');
                if(state != 1) return;
                $('#orderTimeSelWp .active').removeClass('active');
                $this.addClass('active');
                that.activeTime = $this.data('time');
            });
            this.wrap.on('tap', '.order-row li', function(){
                var $this = $(this);
                var state = $this.data('state');
                if( state == 1 ) return;
                var index = $this.data('index');
                var times = XM.order.times['dates'][index];
                var loading = '<div class="loading32"></div>';
                if(!times) return;
                $('.order-row .active').removeClass('active');
                $this.addClass('active');
                that.dateActiveIndex  = index;
                that.activeTime       = '';
                that.$orderTimeSelWp.html( _.template(that.orderTimeSelTpl)( { "date": times } ));
            });
        },
        reset: function(selector){
            $(selector).trigger('change');
        },
        init: function(){
            //this.resetOrderTimes();
            this.wrap      = $("body");
            this.$timeInput      = $("#time");
            this.$qxzfwsj        = $('#qxzfwsj');
            this.defaultTimeText = this.$qxzfwsj.text();
            this.orderTimeTpl    = $("#orderTimeTpl").html();
            this.orderTimeSelTpl = $("#orderTimeSelTpl").html();
            if(!this.orderTimeTpl || !this.orderTimeSelTpl) return;
            this.bindEvt();
        }
    });

    XM.butler = $.extend(XM.butler||{},{
        dlgClose: function(callback){
            var that   = this;
            this.butlerDlg.find('[dlg-act="dlg-hide"], .mask').unbind().on('click', function(){
                var $this = $(this);
                var type  = $this.attr('node-type');
                var $el, id, text = '';
                if(!that.closeSwitch) return;
                that.setBulter(type);
                $(this).parents('.active').remove();
                that.scrollDestory();
                that.closeSwitch = false;
                if(callback) callback.call(that);
            });
        },
        scrollDestory: function(){
            if(!this.myScroll) return;
            this.myScroll.destroy();
            this.myScroll = null;
        },
        setBulter: function(type){
            var $active = this.butlerDlg.find('li.active'),
                _html, ids = [];
            if(type == 'shuffle') {
                _html = "缘分是件很奇妙的事情";
                ids.push("-1");
                $active.removeClass('active');
            } else if(!$active.length) {
                _html = "请选择管家";
                ids.push("0");
            } else {
                _html = $active;
                ids   = [];
                $active.each(function(i, el){
                    var $el = $(el);
                    if($el.length) ids.push($el.data('id'));
                });
            }
            var $el = $('<ul class="butler-list clearfix"></ul>');
            $el.html(_html);
            this.$butlerInput.val(ids.join(','));
            this.$bulterListWp.html($el);
        },
        initBulter: function(){
            var $activeEl = this.$bulterListWp.find('li.active');
            var $scroller = $('#butler-scroller');
            $.each($activeEl, function(index, el){
                var id = $(el).data('id');
                $scroller.find('li[data-id="'+id+'"]').addClass('active').find('input').attr('checked', 'checked');
            });
        },
        fetchBulterList: function(){
            var that = this;
            var opts     = '';
            var $time    = $('#time');
            var type     = '';
            var value    = $time.val() || '请选择服务时间';
            var postData = {};
            $.each(XM.butler.data||{}, function(arg, selector){
                postData[arg] = $.trim($(selector).val());
            });
            that.fetch(postData, function(data){
                var bulters  = data;
                var _html    = _.template(that.tpl)(bulters);
                that.butlers = bulters;
                _opts = $.extend({
                    'content': _html,
                    'clazz'  : 'butler-dlg',
                    'btns'   : '<button class="dlg-btn pull-left" node-type="shuffle" dlg-act="dlg-hide">随缘</button> <button class="dlg-btn  pull-right" dlg-act="dlg-hide">确定</button>',
                    'title'  : '选择为您服务过的管家 <br/> <span id="dlg-serv-time">'+value+'</span>'
                }, opts);
                XM.util.removeTip();
                that.butlerDlg = $('<div></div>').dlg(_opts);
                setTimeout(function(){that.closeSwitch = true;}, 800);
                $('#dlg-serv-time').text(value);
                that.initScroll();
                that.initBulter();
                that.dlgClose();
            });
        },
        bindEvt: function(){
            var that     = this;
            var data     = this.data;
            if(!data) return;
            var selector = [data['address'],data['units'],data['serviceTime']].join(',');
            that.selector = selector;
            that.$wrap.on('click','[data-act="dlg-butler"]', function(e){
                e.preventDefault();
                if(!that.validate()) return;
                XM.util.tips('管家列表获取中',1);
                that.fetchBulterList();
            });
            var listSelector = '.butler-dlg .butler-list li';
            that.$wrap.on('tap', listSelector, function(e){
                var $this  = $(this);
                var state  = $this.data("state");
                var keeperNum = that.$keepernumInput.val();
                if(!that.closeSwitch) return;
                if(state == 1) return;
                if($this.parent('ul').find('li.active').length >= keeperNum) {
                    if($this.hasClass('active')) {
                        $this.toggleClass('active');
                    } else {
                        XM.util.tips('选择的管家已经超过上限', 0, 1);
                    }
                } else {
                    $this.toggleClass('active');
                }
                if($(listSelector).length == 1) {
                    that.butlerDlg.find('.mask').click();
                }
            });
            $(selector).bind('focus __focus',function(){
                var $this = $(this);
                var value = $.trim($this.val());
                $this.attr('origin-value', value);
            });
            $(selector).bind('change __change', function(){
                var $this = $(this);
                console.log('change');
                var value = $.trim($this.val());
                var originVal = $.trim($this.attr('origin-value'));
                if(value != originVal) {
                    that.cancelBulter();
                    if(this.id != data.serviceTime.slice(1)) XM.order.cancleOrderTime();
                }
            });
            $(document).on('touchmove', function (e) {
                if(that.myScroll) e.preventDefault();
            });
        },
        cancelBulter: function(){
            if(!this.$butlerInput || !this.$butlerInput.length) return;
            var value = this.$butlerInput.val();
            if($.inArray(value, ['0', '-1']) < 0) {
                this.$bulterListWp.html('请选择管家');
                this.$butlerInput.val('');
            }
        },
        fetch: function(data, callback){
            var that = this;
            $.ajax({
                "url": this.apiUrl,
                "data": data,
                "type": "POST",
                "dataType": "json",
                "success": function(data){
                    if(data.code == 1) {
                        if(callback) callback.call(that, data);
                    }
                }
            })
        },
        initScroll: function(){
            var $scoller    = $('#butler-scroller');
            var $butlerList = $scoller.find('.butler-list');
            if($butlerList.find('li').length <= 4) {
                $butlerList.css('position', 'static');
                $scoller.height('auto');
                return;
            }
            this.myScroll = new IScroll('#butler-scroller');
        },
        validate: function(){
            var data = XM.butler.data;
            var addr = $.trim($(data['address']).val());
            var type = $.trim($(data['units']).val());
            var time = $.trim($(data['serviceTime']).val());
            //if(!addr) {
            //    XM.util.tips('请输入服务地址', 0, 1);
            //    return false;
            //}
            if(!time) {
                XM.util.tips('请选择服务时间', 0, 1);
                return false;
            }
            if(!type) {
                XM.util.tips('请选择服务类型', 0, 1);
                return false;
            }
            return true;
        },
        init: function(opts){
            this.$wrap = $('body');
            this.closeSwitch   = false;
            this.$bulterListWp = $('#bulterListWp');
            this.$keepernumInput = $('#keepernum');
            this.tpl          = $('#butlerListTpl').html();
            this.$butlerInput = $('#butler-value');
            this.butlers = XM.order.butlers;
            this.opts    = opts;
            this.bindEvt();
            if(!this.tpl) return;
        }
    });

    XM.order.init();
    //管家
    XM.butler.init();

    XM.login = $.extend(XM.login||{},{
        dlg: function(opts){
            var _tpl = $("#loginTpl").html();
            if(!_tpl) return;
            var _html = _.template(_tpl)();
            opts = $.extend({
                'clazz': 'login-dlg',
                'title': '',
                'content': _html
            }, opts);
            this.dlgEl = $('<div></div>').dlg(opts);
            return this;
        },
        close: function(){
            this.dlgEl.remove();
        }
    });
    return XM;
});

