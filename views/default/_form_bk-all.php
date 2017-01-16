<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use andahrm\person\models\Title;

/* @var $this yii\web\View */
/* @var $model andahrm\person\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="person-form">
<?php $form = ActiveForm::begin(); ?>
    <div class="pull-right">
    <?= Html::a('<i class="fa fa-times"></i> Discard', ['index'], ['class' => 'btn btn-default']) ?>
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> '.Yii::t('app', 'Create') : '<i class="fa fa-check"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <h4><?= $model->isNewRecord ? Yii::t('andahrm', 'Create Person') : $model->fullname; ?></h4>
    <hr>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Default</a>
        </li>
        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Detail</a>
        </li>
        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-6" style="border-right: 1px solid #DBDBDB;">
                    <h4 class="page-header" style="margin-top: 0">Information</h4>
                <?= $form->field($model, 'citizen_id')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'title_id')->dropDownList(ArrayHelper::map(Title::find()->all(), 'id', 'name')) ?>

                <?= $form->field($model, 'firstname_th')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lastname_th')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'firstname_en')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lastname_en')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'gender')->inline()->radioList($model->getGenders()) ?>

                <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'birthday')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <h4 class="page-header" style="margin-top: 0">Accounting</h4>
                <?php 
                echo $this->render('_signup', [
                    'model' => $modelUser,
                    'form' => $form,
                    'roleList' => $model->getRoleList()
                ]); 
                ?>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
            <?php
            echo $this->render('_form-detail', ['model' => $modelDetail, 'form' => $form]);
            ?>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
            <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress,
                commodo enim craft beer mlkshk </p>
        </div>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
if($model->isNewRecord) {
$firstname_en_id = Html::getInputId($model, "firstname_en");
$username_id = Html::getInputId($modelUser, "username");

$citizen_id_id =  Html::getInputId($model, "citizen_id");
$password_id = Html::getInputId($modelUser, "newPassword");
$passwordConfirm_id = Html::getInputId($modelUser, "newPasswordConfirm");
$js[] = <<< JS
$(document).on('change', '#{$firstname_en_id}', function(event){ var val = $(this).val().toLowerCase(); $('#$username_id').val(val); });
$(document).on('change', '#{$citizen_id_id}', function(event){ var val = $(this).val().toLowerCase(); $('#$password_id').val(val); $('#$passwordConfirm_id').val(val); });
JS;


$this->registerJs(implode("\n", $js));
}
?>