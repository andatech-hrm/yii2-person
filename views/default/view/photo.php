<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use anda\core\widgets\cropimageupload\CropImageUpload;
?>



<?php
 $modalPreview = Modal::begin([
    'header' => '<h4 class="modal-title">Preview</h4>',
]);
        
echo 'Loading...';

Modal::end();

//////////

$modal = Modal::begin([
    'header' => '<h4 class="modal-title">Photo: '.$photo->year.'</h4>',
]);

echo 'Loading...';
        
Modal::end();
        
        ?>
<div class="photo-index">
    <div class="row">
    <?php foreach($model as $key => $photo) : ?>
    <div class="col-md-4">
        <div class="thumbnail">
            <div class="image view view-first">
                <?= Html::img($photo->getUploadUrl('image_cropped'), ['style' => 'width: 100%; display: block;', 'alt' => 'image']); ?>
                <div class="mask">
                    <p><?= $photo->year; ?></p>
                    <div class="tools tools-bottom">
                        <?php
                        echo Html::a('<i class="fa fa-eye"></i>', $photo->getUploadUrl('image_cropped'), [
                            'title' => Yii::t('andahrm', 'View'),
                            'data-toggle' => 'modal',
                            'data-target' => "#{$modalPreview->id}"
                        ]);
                        
                        echo Html::a('<i class="fa fa-picture-o"></i>', $photo->getUploadUrl('image'), [
                            'title' => Yii::t('andahrm', 'Original'),
                            'target' => '_blank',
                        ]);
                        
                        echo Html::a('<i class="fa fa-pencil"></i>', ['photo-update', 'id'=>$photo->user_id, 'year' => $photo->year], [
                            'title' => Yii::t('andahrm', 'View'),
                            'data-toggle' => 'modal',
                            'data-target' => "#{$modal->id}"
                        ]);
                        
                        echo Html::a('<i class="fa fa-trash"></i>', ['photo-delete', 'id'=>$photo->user_id, 'year' => $photo->year], [
                            'title' => Yii::t('andahrm', 'View'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'title' => Yii::t('andahrm', 'Delete'),
                            'data-method' => 'post'
                        ]);
                        ?>
                        <!--<a href="<?= $photo->getUploadUrl('image_cropped'); ?>" title="<?= Yii::t('andahrm', 'View') ?>" data-toggle="modal" data-target="#<?= $modalPreview->id; ?>"><i class="fa fa-eye"></i></a>-->
                        <!--<a href="<?= $photo->getUploadUrl('image'); ?>" target="_blank" title="<?= Yii::t('andahrm', 'Original') ?>"><i class="fa fa-picture-o"></i></a>-->
                        <!--<a href="<?= Url::to(['photo/update', 'id'=>$photo->user_id, 'year' => $photo->year]); ?>" class="btn-load-form" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Update') ?>"><i class="fa fa-pencil"></i></a>-->
                        <!--<a href="<?= Url::to(['delete', 'id'=>$photo->user_id, 'year' => $photo->year]); ?>" data-confirm="<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>" title="<?= Yii::t('andahrm', 'Delete') ?>" data-method="post"><i class="fa fa-trash"></i></a>-->
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
                <!--<a href="<?= Url::to(['photo-create', 'id'=>$photo->user_id]); ?>" class="btn btn-default btn-block btn-load-form" style="height:100%;font-size: -webkit-xxx-large;display: flex; align-items: center; justify-content: center; color:#26B99A;" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Create') ?>"><i class="fa fa-plus-circle"></i></a>-->
                <?php
                echo Html::a('<i class="fa fa-plus-circle"></i>', ['photo-create', 'id' => $photo->user_id], [
                    'class' => 'btn btn-default btn-block btn-load-form',
                    'style' => 'height:100%;font-size: -webkit-xxx-large;display: flex; align-items: center; justify-content: center; color:#26B99A;',
                    'data-toggle' => 'modal',
                    'data-target' => "#{$modal->id}",
                    'title' => Yii::t('andahrm', 'Create')
                ]);
                ?>
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
    var invoker = $(e.relatedTarget);
    var modal = $(this);
    modal.find('.modal-body').html('Loading...');
    $.ajax({
        url: invoker.attr('href'),
        success: function(data){
            modal.find('.modal-body').html(data);
        }
    });
});
JS;
                   
$js[] = <<< JS
$('#{$modalPreview->id}').on('show.bs.modal', function (e) {
    $('.modal-body').html('<img src="'+e.relatedTarget+'">');
});
JS;

$this->registerJs(implode("\n", $js));