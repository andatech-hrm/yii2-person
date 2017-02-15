<?php
use kartik\detail\DetailView;
use andahrm\person\models\Title;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use andahrm\setting\models\WidgetSettings;

return [
    [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>'<kbd>'.$model->user_id.'</kbd>',
                'displayOnly'=>true
            ],[
                'attribute' => 'citizen_id',
            ],[
                'attribute' => 'title_id',
                'value' => $model->getGenderText(),
                'type' => DetailView::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(Title::find()->all(), 'id', 'name'),
            ],[
                'attribute' => 'fullname_th',
                'value' => $model->getFullname('th'),
                'updateMarkup' => function($form, $widget) {
                $model = $widget->model;
                return '<div class="row">'. 
                    $form->field($model, 'firstname_th', ['options' => ['class' => 'form-group col-sm-6']]) . ' ' .
                    $form->field($model, 'lastname_th', ['options' => ['class' => 'form-group col-sm-6']]) . '</div>';
                }
            ],[
                'attribute' => 'fullname_en',
                'value' => $model->getFullname('en'),
                'updateMarkup' => function($form, $widget) {
                $model = $widget->model;
                return '<div class="row">'. 
                    $form->field($model, 'firstname_en', ['options' => ['class' => 'form-group col-sm-6']]) . ' ' .
                    $form->field($model, 'lastname_en', ['options' => ['class' => 'form-group col-sm-6']]) . '</div>';
                }
            ],[
                'attribute' => 'gender',
                'value' => $model->getGenderText(),
                'type' => DetailView::INPUT_RADIO_LIST,
                'items' => $model->getGenders(),
            ],[
                'attribute' => 'tel',
            ],[
                'attribute' => 'phone',
            ],[
                'attribute' => 'birthday',
                'type'=>DetailView::INPUT_DATE,
                'widgetOptions' => WidgetSettings::DatePicker()
            ],
];