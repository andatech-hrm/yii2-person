<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
###
use andahrm\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;
use andahrm\person\models\PersonRetired;
use andahrm\person\models\Person;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\PersonRetired */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-retired-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?=
                $form->field($model, 'user_id', ['options' => ['class' => 'form-group col-sm-6']])
                ->widget(Select2::className(), [
                    'data' => Person::getList($model->user_id),
                    'options' => [
                        'placeholder' => Yii::t('andahrm/person', 'Fullname'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2, //ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                        'ajax' => [
                            'url' => Url::to(['/person/default/person-list']),
                            'dataType' => 'json', //รูปแบบการอ่านคือ json
                            'data' => new JsExpression('function(params) { return {q:params.term};}')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function (position) { return position.text; }'),
                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                    ],
                ])->label(Yii::t('andahrm/person', 'Fullname'));
        ?>

        <?=
        $form->field($model, 'retired_date', ['options' => ['class' => 'form-group col-sm-6']])->widget(DatePicker::classname(), WidgetSettings::DatePicker([
                        // 'pluginOptions' => [
                        //   'format' => 'yyyy-mm-dd',
                        // ]
        ]));
        ?>

    </div>

    <?=
    $form->field($model, 'because')->radioList(PersonRetired::getItemBecause())
    ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/person', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
