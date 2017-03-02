<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\DetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'nationality_id') ?>

    <?= $form->field($model, 'race_id') ?>

    <?= $form->field($model, 'religion_id') ?>

    <?= $form->field($model, 'blood_group') ?>

    <?php // echo $form->field($model, 'address_contact_id') ?>

    <?php // echo $form->field($model, 'address_birth_place_id') ?>

    <?php // echo $form->field($model, 'address_register_id') ?>

    <?php // echo $form->field($model, 'mother_name') ?>

    <?php // echo $form->field($model, 'father_name') ?>

    <?php // echo $form->field($model, 'married_status') ?>

    <?php // echo $form->field($model, 'people_spouse_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
