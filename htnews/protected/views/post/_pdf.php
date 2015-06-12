<?php
/**
 * Created by PhpStorm.
 * User: Hardik
 * Date: 11/6/15
 * Time: 7:47 PM
 */

/* @var $this PostController */
/* @var $model Post */
?>
<h1><?php echo $model->title; ?></h1>
<div>
    <img src="<?php echo Yii::app()->params['uploadPath'].'/'.$model->image_url; ?>" alt="<?php echo CHtml::encode($model->title); ?>" class="post-image-big"  />
</div>
<br />
<div>
    <?php echo $model->body; ?>
</div>
<br />
<div>
    <b>Published:</b> <?php echo $model->published; ?>
</div>
<br />
<div>
    <b>Author:</b> <?php echo $model->user->email; ?>
</div>