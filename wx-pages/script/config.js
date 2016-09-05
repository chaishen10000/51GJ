var require = {
    baseUrl: "http://xiaomaguanjia.com/weixin/js",
    paths: {
        //zepto  : "zepto",
        Zepto  : "zepto",
        //selector:"zepto/selector",
        ratchet: "ratchet",
        swipe  : "swipe",
        dialog : "zepto.dlg",
        xiaoma : 'xm',
        iscroll: 'iscroll-lite'
    },
    shim: {
        Zepto: {
            exports: '$'
        },
        underscore: {
            exports: '_'
        },
        dialog: {
            deps: ["Zepto", "underscore"],
            exports: '$.fn.dlg'
        }
    }
};
