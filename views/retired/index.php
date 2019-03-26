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
            //'user_id',
            [
                'attribute' => 'user_id',
                //'value' => 'user.fullname',
                //'attribute' => 'fullname',
                'format' => 'raw',
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
                    if (isset($model->lastPosition)) {
                        return $model->lastPosition->title;
                    }
                }
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
