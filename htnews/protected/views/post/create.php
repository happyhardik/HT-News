<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Articles'=>array('list'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage my articles', 'url'=>array('list')),
	array('label'=>'Subscribe to our news feed', 'url'=>array('feed')),
);
?>

<h1>Add new article</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>