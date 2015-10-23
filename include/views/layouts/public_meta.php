<?php $this->renderPartial('//layouts/public_meta_include'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<!-- blueprint CSS framework -->
<link rel="stylesheet" type="text/css" href="<?php echo FF_DOMAIN; ?>/upload/css/global.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo FF_DOMAIN; ?>/upload/css/module.css" />
<!--[if lt IE 8]><![endif]-->
<!--<link rel="stylesheet" type="text/css" href="/upload/css/ie.css"/>-->


<link rel="stylesheet" type="text/css" href="<?php echo FF_DOMAIN; ?>/upload/css/unit.css" />
<link rel="stylesheet" type="text/css" href="<?php echo FF_DOMAIN; ?>/upload/css/function.css" />
<link rel="stylesheet" type="text/css" href="<?php echo FF_DOMAIN; ?>/upload/css/grid.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/lib/js/lib/layer/skin/layer.css">
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/lib/js/lib/layer/skin/myskin.css">
<link rel="icon" href="<?php echo FF_DOMAIN; ?>/upload/images/yhclogo.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FF_DOMAIN; ?>/upload/images/yhclogo.ico" type="image/x-icon" />
<?php
Yii::app()->clientScript->registerScriptFile(FF_STATIC_BASE_URL. "/lib/js/require.js");
?>