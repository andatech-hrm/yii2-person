<?php
use yii\bootstrap\Html;
?>
<?php $roleList = \andahrm\person\models\Person::getRoleList(); ?>

        <?= $form->field($model, 'username')->label(Yii::t('andahrm/person', 'Username'));?>

        <?= $form->field($model, 'email')->label(Yii::t('andahrm/person', 'Email'));?>
        <?php if($model->isNewRecord) : ?>
        <?= $form->field($model, 'newPassword')->passwordInput()->label(Yii::t('andahrm/person', 'Password'));?>

        <?= $form->field($model, 'newPasswordConfirm')->passwordInput()->label(Yii::t('andahrm/person', 'Confirm password'));?>
        <?php endif; ?>
        <?= $form->field($model, 'status')->inline()->radioList($model->getStatusList())->label(Yii::t('andahrm/person', 'Status'));?>
        
        
            <?php 
            $roles = Yii::$app->authManager->getRolesByUser($model->id);
            ?>
        <div class="form-group required">
            <label class="control-label" for="role"><?= Yii::t('andahrm/person', 'Roles'); ?></label>
            <div class="well">
            <?= Html::checkBoxList('Roles', array_keys($roles), $roleList, ['separator' => '<br>']); ?>
            </div>
            <?php //echo Html::dropDownList('role', null, $roleList, ['class'=>'form-control', 'id' => 'role']); ?>
        </div>
        <?php
        if(!$model->isNewRecord) {
            echo Html::a('<i class="fa fa-user-secret"></i> Manage Account', ['/user/admin'], ['class' => 'btn btn-dark btn-block text-red', 'target' => '_blank']);
        }
        ?>