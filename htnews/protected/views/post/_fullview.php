<?php
/* @var $this PostController */
/* @var $model Post */
?>
<h1><?php echo $model->title; ?></h1>
<div>
    <img src="<?php echo Yii::app()->params['uploadPath'].'/'.$model->image_url; ?>" alt="<?php echo CHtml::encode($model->title); ?>" class="post-image-big"  />
</div>
<div class="padder10">
    <?php echo $model->body; ?>
</div>
<div class="padder10">
    <b>Published:</b> <?php echo $model->published; ?>
</div>
<div class="padder10">
    <b>Author:</b> <?php echo $model->user->email; ?>
</div>