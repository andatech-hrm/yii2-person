<?php

use yii\helpers\Html;
use yii\helpers\Url;
use andahrm\setting\models\Helper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use anda\core\widgets\cropimageupload\CropImageUpload;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\PhotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Photos');
$this->params['breadcrumbs'][] = $this->title;
$ctrl = $this->context->module->id.'/'.$this->context->id.'/';
?>
<?php
 $modal = Modal::begin([
    'header' => '<h4 class="modal-title">Photo</h4>',
]);
        
echo 'Loading...';

Modal::end();
?>
<?php
 $modalPreview = Modal::begin([
    'header' => '<h4 class="modal-title">Preview</h4>',
]);
        
echo 'Loading...';

Modal::end();
?>
<div class="photo-index">
    <h4><?= $modelPerson->fullname; ?></h4>
    <div class="row">
    <?php foreach($model as $key => $photo) : ?>
    <div class="col-md-4">
        <div class="thumbnail">
            <div class="image view view-first">
                <?= Html::img($photo->getUploadUrl('image_cropped'), ['style' => 'width: 100%; display: block;', 'alt' => 'image']); ?>
                <div class="mask">
                    <p><?= $photo->year; ?></p>
                    <div class="tools tools-bottom">
                        <a href="<?= $photo->getUploadUrl('image_cropped'); ?>" title="<?= Yii::t('andahrm', 'View') ?>" data-toggle="modal" data-target="#<?= $modalPreview->id; ?>"><i class="fa fa-eye"></i></a>
                        <a href="<?= $photo->getUploadUrl('image'); ?>" target="_blank" title="<?= Yii::t('andahrm', 'Original') ?>"><i class="fa fa-picture-o"></i></a>
<!--                         <a href="<?= Url::to(['update', 'id'=>$photo->user_id, 'year' => $photo->year]); ?>" class="btn-load-form" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Update') ?>"><i class="fa fa-pencil"></i></a> -->
                        <a href="<?= Url::to(Helper::urlParams('update',['id'=>$photo->user_id, 'year' => $photo->year])); ?>" class="btn-load-form" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Update') ?>"><i class="fa fa-pencil"></i></a>
                        <a href="<?= Url::to(Helper::urlParams('delete',['id'=>$photo->user_id, 'year' => $photo->year])); ?>" data-confirm="<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>" title="<?= Yii::t('andahrm', 'Delete') ?>" data-method="post"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <h3><?= $photo->year; ?></h3>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
        
    <div class="col-md-4">
        <div class="thumbnail">
            <div class="image view view-first">
                <a href="<?= Url::to(Helper::urlParams('create',['id'=>$photo->user_id])); ?>" class="btn btn-default btn-block btn-load-form" style="height:100%;font-size: -webkit-xxx-large;display: flex; align-items: center; justify-content: center; color:#26B99A;" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Create') ?>"><i class="fa fa-plus-circle"></i></a>
            </div>
            <div class="caption text-center">
                <h3><?= Yii::t('andahrm', 'Create') ?></h3>
            </div>
        </div>
    </div>
</div>
</div>
<?php
$js[] = <<< JS
$('#{$modal->id}').on('show.bs.modal', function (e) {
    $('.modal-body').html('<div style="height:200px;font-size: -webkit-xxx-large;display: flex; align-items: center; justify-content: center;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
     $.get( e.relatedTarget, function( data ) {
         $( ".modal-body" ).html( data );
     });
});
JS;
                   
$js[] = <<< JS
$('#{$modalPreview->id}').on('show.bs.modal', function (e) {
    $('.modal-body').html('<img src="'+e.relatedTarget+'">');
});
JS;

$this->registerJs(implode("\n", $js));
