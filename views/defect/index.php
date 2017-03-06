<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use andahrm\person\models\Person;
use andahrm\edoc\models\Edoc;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\person\models\DefectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Defects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defect-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/person', 'Create Defect'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            [
                 'attribute'=>'user_id',
                'filter' => Person::getList(),
                'format'=>'html',
                'value' => 'user.infoMedia'
            ],
            'date_defect',
            'title',
            'detail:ntext',
            [
                'attribute'=>'edoc_id',
                'filter' => Edoc::getList(),
                'format' => 'html',
                'value' => 'edoc.codeTitle',
          //'group'=>true,
            ],
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
