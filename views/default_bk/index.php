<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'user_id',
        'citizen_id',
        'title_id',
        'firstname_th',
        'lastname_th',
        'firstname_en',
        'lastname_en',
        'gender',
        'tel',
        'phone',
        'birthday',
    ],
]) ?>