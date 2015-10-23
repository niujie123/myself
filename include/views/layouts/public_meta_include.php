<title>萤火虫理财-点亮你的财富人生</title>
<meta name="keywords" content="萤火虫理财|萤火虫">
<meta name="description" content="萤火虫理财隶属于萤火虫金融服务集团有限公司，旗下业务主要包括小微金融和互联网金融服务。信息技术的发展，尤其是移动互联网时代的到来，社会生产组织发展模式越来越极端，一边是少量规模化巨无霸企业，一边是众多的小微化专业企业。萤火虫理财将充分依托移动互联网技术基础，进行有效数据系统分析，为小微企业提供综合金融服务，探索并发展互联网金融产业。">
<script>
    var GLOBAL_CF = {
        BASE_URL : '<?php echo FF_STATIC_BASE_URL."/lib/js";?>'
    };
    var FIREFLY = {};
    /**
     * 脚本加载项
     * Created by Administrator on 15-3-31.
     */
    requirejs.config({

        paths: {
            jquery: GLOBAL_CF.BASE_URL+'/lib/jquery-1.8.3',
            common: GLOBAL_CF.BASE_URL+'/common',
            verifyCode: GLOBAL_CF.BASE_URL+'/verifyCode',
            flexslider: GLOBAL_CF.BASE_URL+'/lib/jquery.flexslider-min',
            validate: GLOBAL_CF.BASE_URL+'/lib/jquery.validate',
            tabso_yeso: GLOBAL_CF.BASE_URL+'/lib/jquery.tabso_yeso',
            poshytip: GLOBAL_CF.BASE_URL+'/lib/jquery.poshytip.min',
            validate_method: GLOBAL_CF.BASE_URL+'/lib/validate_Method',
            layer:GLOBAL_CF.BASE_URL+'/lib/layer/layer'
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
</script>