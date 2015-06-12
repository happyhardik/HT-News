<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    'Account Verification',
);

?>

    <h1>Account Verification</h1>

<?php $this->renderPartial('_password', array('model'=>$model)); ?>