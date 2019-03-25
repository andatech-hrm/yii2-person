<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\PersonRetiredSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Person Retireds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-retired-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/person', 'Create Person Retired'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user_id',
            [
                'attribute' => 'user_id',
                'value' => 'user.fullname',
            ],
            [
                'attribute' => 'last_position_id',
                'value' => 'lastPosition.title',
            ],
            [
                'attribute' => 'because',
                'value' => 'becauseLabel'
            ],
            'retired_date:date',
            'note',
            [
                //'attribute' => 'because',
                'content' => function($model) {
                    return Html::a('ดูรายละเอียด', ['view', 'id' => $model->user_id]);
                }
            ],
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
