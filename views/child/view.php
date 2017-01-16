<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Child */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/person', 'Update'), ['update', 'user_id' => $model->user_id, 'people_id' => $model->people_id, 'relation' => $model->relation], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/person', 'Delete'), ['delete', 'user_id' => $model->user_id, 'people_id' => $model->people_id, 'relation' => $model->relation], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/person', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'people_id',
            'relation',
        ],
    ]) ?>

</div>
