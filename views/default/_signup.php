<?php
use yii\bootstrap\Html;
?>
<div class="x_panel">
    <div class="x_title">
        <h2>Accounting</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?= $form->field($model, 'username');?>

        <?= $form->field($model, 'email');?>

        <?= $form->field($model, 'newPassword')->passwordInput();?>

        <?= $form->field($model, 'newPasswordConfirm')->passwordInput();?>
        
        <?= $form->field($model, 'status')->dropDownList($model->getStatusList());?>
        
        <div class="form-group required">
            <label class="control-label" for="role">Role</label>
            <?= Html::dropDownList('role', null, $roleList, ['class'=>'form-control', 'id' => 'role']); ?>
        </div>
        
    </div>
</div>