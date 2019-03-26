<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\PersonRetired */
$fullname = isset($model->user) ? $model->user->fullname : $model->user_id;
$this->title = $fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person Retireds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-retired-view">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
    <?= Html::a(Yii::t('andahrm/person', 'Update'), ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
    <?=
    Html::a(Yii::t('andahrm/person', 'Delete'), ['delete', 'id' => $model->user_id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('andahrm/person', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ])
    ?>
    </p>-->

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                //'value' => $fullname,
                'format' => 'html',
                'value' => function($model) {
                    $old_position = '';
                    if (isset($model->lastPosition)) {
                        $old_position = $model->lastPosition->title;
                    }
                    if (isset($model->user)) {
                        $res = '<div class="media"> <div class="media-left"> ' .
                                '<img class="media-object img-circle" src="' . $model->user->photo . '" style="width: 32px; height: 32px;"> </div> ' .
                                '<div class="media-body"> ' .
                                '<h4 class="media-heading" style="margin:0;">' .
                                Html::a($model->user->fullname, ['/person/default/view', 'id' => $model->user->user_id], ['class' => 'green', 'data-pjax' => 0]) . '</h4> ' .
                                '<small>' . $old_position . '<small></div> </div>';
                        return $res;
                    } else {
                        return $model->user->fullname;
                    }
                }
            ],
            [
                'attribute' => 'last_position_id',
                'value' => function($model) {
                    return isset($model->lastPosition) ? $model->lastPosition->title : null;
                }],
            [
                'attribute' => 'because',
                'value' => $model->becauseLabel
            ],
            'retired_date:date',
            'note',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ])
    ?>

</div>
