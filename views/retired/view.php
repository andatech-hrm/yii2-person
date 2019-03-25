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
                'value' => $fullname,
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
