<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Articles',
);

$this->menu=array(
	array('label'=>'Submit news article', 'url'=>array('create')),
	array('label'=>'My Articles', 'url'=>array('list')),
    array('label'=>'Subscribe (RSS)', 'url'=>array('feed')),
);
?>

<h1>Articles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'template'=>'{items} {pager}'
)); ?>
