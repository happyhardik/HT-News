<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Login', 'url'=>array('site/login')),
);
?>

<h1>Create an account</h1>

<?php $this->renderPartial('_create', array('model'=>$model)); ?>