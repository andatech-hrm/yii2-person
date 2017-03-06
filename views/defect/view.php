<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use andahrm\person\models\Person;
use andahrm\edoc\models\Edoc;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Defect */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Defects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defect-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/person', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/person', 'Delete'), ['delete', 'id' => $model->id], [
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
    
            [
                 'attribute'=>'user_id',
                'filter' => Person::getList(),
                'format'=>'raw',
                'value' => $model->user->infoMedia
            ],
            'date_defect:date',
            'title',
            'detail:ntext',
            [
                'attribute'=>'edoc_id',
                'filter' => Edoc::getList(),
                'format' => 'raw',
                'value' => $model->edoc->codeTitle,
          //'group'=>true,
            ],
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
