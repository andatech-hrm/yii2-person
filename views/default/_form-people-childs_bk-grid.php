<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

use andahrm\person\models\PeopleChild;
use andahrm\person\models\PeopleChildSearch;

$newChild = new PeopleChild();
?>
<?php
$dataProvider = new ArrayDataProvider([
    'allModels' => $model,
    'pagination' => false,
    'sort' => [
        'attributes' => ['id', 'name'],
    ],
]);

?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>true,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            //'type',
            [
                'attribute' => 'citizen_id',
                'footer' => Html::activeTextInput($newChild, 'citizen_id', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'name',
                'footer' => Html::activeTextInput($newChild, 'name', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'surname',
                'footer' => Html::activeTextInput($newChild, 'surname', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'birthday',
                'footer' => Html::activeTextInput($newChild, 'birthday', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'nationality_id',
                'footer' => Html::activeTextInput($newChild, 'nationality_id', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'race_id',
                'footer' => Html::activeTextInput($newChild, 'race_id', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'occupation',
                'footer' => Html::activeTextInput($newChild, 'occupation', ['class' => 'form-control', 'style' => 'margin:0;'])
            ], [
                'attribute' => 'live_status',
                'footer' => Html::activeDropDownList($newChild, 'live_status', $newChild->getLiveStatuses(), ['class' => 'form-control', 'style' => 'margin:0;'])
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'footer' => Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-success', 'id' => 'add-child'])
            ],
        ],
    ]);  ?>
