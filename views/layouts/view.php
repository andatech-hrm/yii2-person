<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalaryOld;

use andahrm\person\PersonApi;
?>
<?php
// $profile = $user->profile;
// $person = Person::findOne($user->id);
$person = PersonApi::instance(Yii::$app->request->get('id'));
// print_r($person);
// exit();
$module = $this->context->module->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="x_panel">
    <!--<div class="x_title">-->
    <!--    <h2>User Report <small>Activity report</small></h2>-->
    <!--    <div class="clearfix"></div>-->
    <!--</div>-->
    <div class="x_content">

        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div id="veiw_sidebar" data-spy="affix" data-offset-top="200">
            <div class="profile_img">

                <!-- end of image cropping -->
                <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" src="<?= $person->getPhoto(); ?>" alt="Avatar" title="Change the avatar" width="100%">
                    <!-- Loading state -->
                    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                </div>
                <!-- end of image cropping -->

            </div>
            <h3><?= $person->getFullname(); ?></h3>

            <ul class="list-unstyled user_data">
                <li>
                    <i class="fa fa-map-marker user-profile-icon"></i>
                    <?= $person->getAddress(); ?>
                </li>

                <li>
                    <i class="fa fa-briefcase user-profile-icon"></i>
                    <?=$person->getPosition(); ?>
                </li>
                <li>
                    <i class="fa fa-briefcase user-profile-icon"></i>
                    <?=$person->getSection(); ?>
                </li>
            </ul>

            <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a> -->
            
            <?=Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('andahrm/person', 'Print'),
                 ['print','id'=>$person->_model->user_id], 
                 [
                        'class' => 'btn btn-default btn-flat',
                        'target' => '_blank',
                        'data-pjax' => 0
                ]);
            ?>
            </div>
<?php
$js[] = <<< JS
$('#veiw_sidebar').on('affix.bs.affix', function(){
    var pl = $(this).closest('.profile_left');
    $(this).css({
        width: pl.width() + 'px',
        top: '10px'
    });
});
JS;
?>

        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">
<?php

$modelPosition = PersonPositionSalary::find()->where(['user_id' => Yii::$app->request->get('id')])
    ->orderBy(['adjust_date'=> SORT_ASC])
    ->all();
$modelPositionOld = PersonPositionSalaryOld::find()->where(['user_id' => Yii::$app->request->get('id')])
    ->orderBy(['adjust_date'=> SORT_ASC])
    ->all();
        
$data = ArrayHelper::merge($modelPositionOld,$modelPosition);
?>
<?php
if(count($data) === 0) : ?>
<div class="alert alert-warning" role="alert">
    <?= $person->fullname; ?> ยังไม่มีประวัติการทำงาน
    <div class="pull-right">
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Position New'), ['create-position','id'=>$person->getModel()->user_id], ['class' => 'btn btn-warning btn-xs',]); ?>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm/person', 'Create Position Old'), ['create-position-old','id'=>$person->getModel()->user_id], ['class' => 'btn btn-warning btn-xs',]); ?>
        <!--<a href="#" class="alert-link">...</a>-->
    </div>
  
</div>
<?php endif ?>

            
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <?php
            $request = Yii::$app->request;
            $menuItems = [];
                $menuItems[] =  [
                        'label' => Yii::t('andahrm/person', 'Information'),
                        'url' => ['view', 'id' => $request->get('id')],
                        'icon' => 'fa fa-info-circle'
                    ];             
                    
                $menuItems[] =  [
                        'label' => Yii::t('andahrm/person', 'Position'),
                        'url' => ['view-position', 'id' => $request->get('id')],
                        'icon' => 'fa fa-briefcase'
                    ];          
                    
                $menuItems[] =  [
                        'label' =>  Yii::t('andahrm/person', 'Development'),
                        'url' => ['view-development', 'id' => $request->get('id')],
                        'icon' => 'fa fa-cogs'
                    ];       
                    
                $menuItems[] =  [
                        'label' => Yii::t('andahrm/person', 'Prestige'),
                        'url' => ['view-prestige', 'id' => $request->get('id')],
                        'icon' => 'fa fa-trophy'
                    ];         
                    
                // $menuItems[] =  [
                //         'label' => Yii::t('andahrm/person', 'Kp'),
                //         'url' => ['view-kp', 'id' => $request->get('id')],
                //         'icon' => 'fa fa-list-alt'
                //     ];
                    
            // echo Menu::widget([
            //     'options' => ['class' => 'nav nav-tabs bar_tabs'],
            //     'encodeLabels' => false,
            //     'items' => $menuItems,
            // ]);
            ?>
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <?php foreach($menuItems as $key => $item) : ?>
                <li role="presentation" class="<?= ($this->context->action->id === $item['url'][0]) ? 'active' : null ?>">
                    <a href="<?= Url::to($item['url'])?>"><i class="<?= $item['icon']; ?>"></i> <?= $item['label']; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" aria-labelledby="profile-tab">
                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs(implode("\n", $js)); ?>

<?php $this->endContent(); ?>

