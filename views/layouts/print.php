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
$user_id = Yii::$app->request->get('id');
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


        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-4 profile_left">
                <div class="profile_img">

                    <!-- end of image cropping -->
                    <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="<?= $person->getPhoto(); ?>" alt="Avatar" title="Change the avatar" width="100%" />
                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                    </div>
                    <!-- end of image cropping -->

                </div>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-8 ">
                <h3><?= $person->getFullname(); ?></h3>

                <ul class="list-unstyled user_data">
                    <?php if ($person->getAddress()): ?>
                        <li>
                            <i class="fa fa-map-marker user-profile-icon"></i>
                            <?= $person->getAddress(); ?>
                        </li>
                    <?php endif; ?>

                    <?php if ($person->getPosition()): ?>
                        <li>
                            <i class="fa fa-briefcase user-profile-icon"></i>
                            <?= Html::a($person->getPosition(), ['/structure/position/view', 'id' => $person->positionId]); ?>
                        </li>
                    <?php endif; ?>

                    <?php if ($person->getSection()): ?>
                        <li>
                            <i class="fa fa-sitemap"></i>                            
                            <?= Html::a($person->getSection(), ['/structure/section/view', 'id' => $person->sectionId]); ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>            
        </div>
        <div class="row">
            <div class="col-xs-12">               

                <?= $content; ?>
            </div>
        </div>
    </div>
</div>


<?php $this->endContent(); ?>

