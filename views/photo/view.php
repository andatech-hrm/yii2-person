<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Photo */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'user_id' => $model->user_id, 'year' => $model->year], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'user_id' => $model->user_id, 'year' => $model->year], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'year',
            'image',
            'image_crop',
            'image_cropped',
            'created_at',
            'created_by',
            'update_at',
            'update_by',
        ],
    ]) ?>

</div>
