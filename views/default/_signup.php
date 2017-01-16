<?php
use yii\bootstrap\Html;
?>

        <?= $form->field($model, 'username');?>

        <?= $form->field($model, 'email');?>
        <?php if($model->isNewRecord) : ?>
        <?= $form->field($model, 'newPassword')->passwordInput();?>

        <?= $form->field($model, 'newPasswordConfirm')->passwordInput();?>
        <?php endif; ?>
        <?= $form->field($model, 'status')->dropDownList($model->getStatusList());?>
        
        <div class="form-group required">
            <label class="control-label" for="role">Role</label>
            <?= Html::dropDownList('role', null, $roleList, ['class'=>'form-control', 'id' => 'role']); ?>
        </div>
        <?php
        if(!$model->isNewRecord) {
            echo Html::a('<i class="fa fa-user-secret"></i> Manage Account', ['/user/admin'], ['class' => 'btn btn-dark btn-block text-red', 'target' => '_blank']);
        }
        ?>