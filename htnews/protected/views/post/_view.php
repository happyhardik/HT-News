<?php
/* @var $this PostController */
/* @var $data Post */
?>

<div class="view">

	<div class="floating post-image">
        <img src="<?php echo Yii::app()->params['uploadPath'].'/'.$data->image_url; ?>" alt="<?php echo CHtml::encode($data->title); ?>" class="thumbnail" />
	</div>
    <div class="floating post-content">
        <h1><?php echo CHtml::link(Utils::truncate(CHtml::encode($data->title),50),array('post/view','id'=>$data->id)); ?></h1>
        <?php echo Utils::truncate(CHtml::encode($data->body),180); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
        <?php echo CHtml::encode($data->published); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
        <?php echo CHtml::encode($data->user->email); ?>
        <br />
    </div>
    <br class="clearBoth" />

</div>