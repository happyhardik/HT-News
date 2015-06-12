<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Go Back', 'url'=>array('index')),
	array('label'=>'Download this article (pdf)', 'url'=>array('download', 'id' => $model->id), 'linkOptions' => array('target' => '_blank')),
);
?>

<?php echo $this->renderPartial("_fullview", array('model' => $model)); ?>

