<?php
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php
$request = Yii::$app->request;
$profile = Yii::$app->user->identity->profile;
$module = $this->context->module->id;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>User Report <small>Activity report</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                        <div class="profile_img">
                            <img class="img-responsive avatar-view" src="<?= $profile->resultInfo->avatar; ?>" alt="Avatar" title="Change the avatar">
                        </div>
                        <h3><?= $profile->fullname; ?></h3>

                        <ul class="list-unstyled user_data">
                            <li><i class="fa fa-map-marker user-profile-icon"></i> San Francisco, California, USA
                            </li>

                            <li>
                                <i class="fa fa-briefcase user-profile-icon"></i> Software Engineer
                            </li>

                            <li class="m-top-xs">
                                <i class="fa fa-external-link user-profile-icon"></i>
                                <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                            </li>
                        </ul>

                        <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <div class="row hidden-print">
                            <div class="col-sm-12"> 
                                <?php
                                $menuItems = [
                                    [
                                        'label' => '<i class="fa fa-history"></i> ' . Yii::t('andahrm/person', 'History'),
                                        'url' => ["/{$module}/default"],
                                    ],                      
                                    [
                                        'label' => '<i class="fa fa-camera"></i>  ' . Yii::t('andahrm/person', 'Photo'),
                                        'url' => ["/{$module}/photo"],
                                    ], 
                                ];
//                                 $menuItems = Helper::filter($menuItems);

                                //$nav = new Navigate();
                                echo Menu::widget([
                                    'options' => ['class' => 'nav nav-tabs'],
                                    'encodeLabels' => false,
                                    //'activateParents' => true,
                                    //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                                    'items' => $menuItems,
                                ]);
                                ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12"><?= $content; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
