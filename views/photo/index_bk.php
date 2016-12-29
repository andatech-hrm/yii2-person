<?php

use yii\helpers\Html;
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
<div class="photo-index">
    <?php foreach($model as $key => $photo) : ?>
    
    
    <div class="col-md-55">
        <?php
//         $form = ActiveForm::begin([
//             'action' => ['update', 'user_id' => $photo->user_id, 'year' => $photo->year],
//             'options' => [
//                 'enctype' => 'multipart/form-data',
//             ]
//         ]);

        $modal = Modal::begin([
            'header' => '<h4 class="modal-title">Image '.$photo->year.'</h4>',
            'options' => [
                'class' => 'modal-change-image',
            ],
//             'footer' => Html::submitButton('<i class="fa fa-check-circle-o" aria-hidden="true"></i> '.Yii::t('andahrm', 'Update'), ['class'=>'btn btn-primary']),
        ]);

        echo Yii::$app->runAction($ctrl.'update', ['user_id' => $photo->user_id, 'year' => $photo->year]);

//         echo $form->field($photo, 'year');
//         echo $form->field($photo, 'image')->widget(CropImageUpload::className());

        Modal::end();

//         ActiveForm::end();
        ?>
        <div class="thumbnail">
            <div class="image view view-first">
                <?= Html::img($photo->getUploadUrl('image_cropped'), ['style' => 'width: 100%; display: block;', 'alt' => 'image']); ?>
                <div class="mask">
                    <p><?= $photo->year; ?></p>
                    <div class="tools tools-bottom">
                        <a href="<?= $photo->getUploadUrl('image_cropped'); ?>" target="_blank" title="<?= Yii::t('andahrm', 'View') ?>"><i class="fa fa-eye"></i></a>
                        <a href="<?= $photo->getUploadUrl('image'); ?>" target="_blank" title="<?= Yii::t('andahrm', 'Original') ?>"><i class="fa fa-picture-o"></i></a>
                        <a href="" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Update') ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" title="<?= Yii::t('andahrm', 'Delete') ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <h3><?= $photo->year; ?></h3>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
    
    
    
    
     
    <div class="col-md-55">
        <?php
//         $modelCreate = new \andahrm\person\models\Photo();
//         $formCerate = ActiveForm::begin([
//             'action' => ['create'],
//             'options' => [
//                 'enctype' => 'multipart/form-data',
//             ]
//         ]);

        $modalCreate = Modal::begin([
            'header' => '<h4 class="modal-title">Create</h4>',
            'options' => [
                'class' => 'modal-create-image',
            ],
        ]);
        
        echo Yii::$app->runAction($ctrl.'create');

//         echo $formCerate->field($modelCreate, 'year');
//         echo $formCerate->field($modelCreate, 'image')->widget(CropImageUpload::className());

        Modal::end();

//         ActiveForm::end();
        ?>
        <div class="thumbnail">
            <div class="image view view-first">
                <a href="" class="btn btn-success btn-block" style="height:100%;font-size: -webkit-xxx-large;display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#<?= $modalCreate->id; ?>" title="<?= Yii::t('andahrm', 'Create') ?>"><i class="fa fa-plus-circle"></i></a>
            </div>
            <div class="caption text-center">
                <h3><?= Yii::t('andahrm', 'Create') ?></h3>
            </div>
        </div>
    </div>
</div>