<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php $this->renderPartial('//layouts//public_meta'); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <?php $this->renderPartial('//layouts/public_head'); ?>

	<?php echo $content; ?>

	<div class="clear"></div>

    <?php
    $access = array('error',);
    if(!in_array($this -> action, $access)){
        $this->renderPartial('//layouts/public_footer');
    }
     ?>

</div><!-- page -->

</body>
</html>
