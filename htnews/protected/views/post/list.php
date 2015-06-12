<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
    'Articles'=>array('list'),
    'Manage',
);

$this->menu=array(
    array('label'=>'Add new news article', 'url'=>array('create')),
    array('label'=>'Subscribe to our news feed', 'url'=>array('feed')),
);


?>

<h1>Manage news articles</h1>

<p>
    List of news articles published by you. You can delete or add new articles from here.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'post-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        'published',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{delete}',
        ),
    ),
)); ?>
