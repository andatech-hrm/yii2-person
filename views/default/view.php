<?php
use kartik\detail\DetailView;
use andahrm\person\models\Title;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use andahrm\setting\models\WidgetSettings;
?>
<?php
$detailViewConfig = [
    'formClass' => '\yii\bootstrap\ActiveForm',
    'formOptions' => ['options' => ['class' => 'form-detail']],
    'buttons1' => '{update}',
    'vAlign' => DetailView::ALIGN_TOP,
    'panel'=>[
        'heading'=>'View # ' . $models['person']->fullname,
        'type'=>DetailView::TYPE_INFO,
    ],
];

?>
<div class="profile-default-index">
    <?php
        $mkey = 'person';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-person', ['model' => $models[$mkey]]),
    ]));
    ?>
    
    <?php
    $mkey = 'detail';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> 'Detail # ' . $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-detail', ['model' => $models[$mkey]]),
    ]));
    ?>
    
    <?php
    $mkey = 'address-contact';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> 'Address Contact # ' . $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-address', ['model' => $models[$mkey], 'header' => 'Address Contact']),
    ]));
    ?>
    
    <?php
    $mkey = 'address-register';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> 'Address Register # ' . $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-address', ['model' => $models[$mkey], 'header' => 'Address Contact']),
    ]));
    ?>
    
    <?php
    $mkey = 'address-birth-place';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> 'Address Birth Place # ' . $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-address', ['model' => $models[$mkey], 'header' => 'Address Contact']),
    ]));
    ?>
    
    <?php
    $mkey = 'people-father';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> 'Father # ' . $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-people', ['model' => $models[$mkey], 'header' => 'Father']),
    ]));
    ?>
    
    <?php
    $mkey = 'people-mother';
    echo DetailView::widget(array_replace_recursive($detailViewConfig, [
        'id' => 'detail-view-'.$mkey,
        'model'=>$models[$mkey],
        'panel'=>[
            'heading'=> 'Mother # ' . $models['person']->fullname . '<span class="label label-success pull-right">Last update: ' . Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</span>',
        ],
        'attributes'=> $this->context->detailViewAttributes('_detail-view-people', ['model' => $models[$mkey], 'header' => 'Mother']),
    ]));
    ?>
</div>

<?php $this->render('detail-view/_address-js'); ?>


