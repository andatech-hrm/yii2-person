<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Detail */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'id' => $model->user_id], [
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
            'nationality_id',
            'race_id',
            'religion_id',
            'blood_group',
            'address_contact_id',
            'address_birth_place_id',
            'address_register_id',
            'mother_name',
            'father_name',
            'married_status',
            'people_spouse_id',
        ],
    ]) ?>

</div>
