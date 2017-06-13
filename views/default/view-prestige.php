<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use andahrm\insignia\models\InsigniaRequest;
use andahrm\insignia\models\InsigniaType;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\insignia\models\InsigniaRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/person', 'Prestige');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->fullname, 'url' => ['view', 'id' => $models['person']->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insignia-request-index">
    <p>
        <?= Html::a(Yii::t('andahrm/insignia', 'Create Insignia Request'), ['request'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // [
            //     'attribute'=> 'person_type_id',
            //     'filter'=>PersonType::getForInsignia(),
            //     'headerOptions'=>['width'=>'150'],
            //     'value' => 'personType.title'
                
            //     ],
                [
                'attribute'=> 'insigniaRequest.year',
                'filter'=>FiscalYear::getList(),
                'value' => function($model){
                    return $model->insigniaRequest->yearTh;
                    }
                ],
                [
                'attribute'=> 'insignia_type_id',
                'filter'=>InsigniaType::getList(),
                'format'=>'html',
                'value' => 'insigniaType.titleIcon'
                ],
                
                
                [
                'attribute'=> 'insigniaRequest.status',
                'filter'=>InsigniaRequest::getItemStatus(),
                'value' => function($model){
                    return $model->insigniaRequest->statusLabel;
                }
                
                ],
           

            
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
