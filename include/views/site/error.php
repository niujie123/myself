<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<!--<h2>Error <?php /*echo $code; */?></h2>

<div class="error">
<?php /*echo CHtml::encode($message); */?>
</div>-->
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/page404/page404.css" />
<!-- 404页面 -->
<div id="pg-404">
    <div class="g-in">
        <div class="main"></div>
        <p class="no-page">您访问的页面不存在...</p>
        <p class="link"><a class="go-home" href="#" >回主页</a><a class="go-back" href="#" >上一步</a></p>
    </div>
</div>
<!-- end 404页面 -->