/**
 * 脚本加载项
 * Created by Administrator on 15-3-31.
 */
requirejs.config({

    paths: {
        jquery: './lib/jquery-1.8.3',
        flexslider: './lib/jquery.flexslider-min',
        validate: './lib/jquery.validate',
        validate_method: './lib/validate_Method',
        tabso_yeso: './lib/jquery.tabso_yeso',
        poshytip:'./lib/jquery.poshytip.min',
        layer:'./lib/layer/layer'
    },
    shim: {
        'flexslider': ['jquery'],
        'validate':['jquery'],
        'validate_method':['jquery'],
        'tabso_yeso':['jquery'],
        'poshytip':['jquery'],
        'layer':['jquery']
    }
});

require(['jquery','flexslider'], function ($,flexslider) {
    $(document).ready(function () {
        //alert($().jquery);

    })
});



