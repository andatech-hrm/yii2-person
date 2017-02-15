<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use andahrm\setting\widgets\XPanel;
use yii\bootstrap\ActiveForm;
// use kartik\detail\DetailView;
use andahrm\person\models\Title;
use andahrm\person\models\Religion;
use yii\helpers\ArrayHelper;
// use kartik\widgets\Select2;
// use kartik\widgets\DatePicker;
// use andahrm\setting\models\WidgetSettings;
?>
<?php
// $detailViewConfig = [
//     'formClass' => '\yii\bootstrap\ActiveForm',
//     'formOptions' => ['options' => ['class' => 'detail-view-form']],
//     'mode' => DetailView::MODE_EDIT,
//     'striped' => false,
//     'bordered' => false,
//     // 'buttons1' => '{update}',
//     'buttons2' => '{reset} {save}',
//     'vAlign' => DetailView::ALIGN_TOP,
//     // 'panel'=>[
//     //     'heading'=>'View # ' . $models['person']->fullname,
//     //     'type'=>DetailView::TYPE_DEFAULT,
//     //     'footer' => '{buttons}<div class="clearfix"></div>',
//     // ],
// ];
$modalOptions = [
    'form-buttons' => Html::resetButton('<i class="fa fa-recycle"></i> Reset', ['class' => 'btn btn-default']) . Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary btn-modal-save']),
    'header-options' => [
        'class' => 'bg-primary',
        'style' => 'border-top-left-radius:5px; border-top-right-radius:5px;'
    ]
];
?>
<div class="profile-default-index">
    <div class="row">
        <div class="col-sm-3 profile_left hidden-xs">
            <div id="veiw_sidebar" data-spy="affix" data-offset-top="200">
            <div class="profile_img">
                <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" src="<?= $models['person']->getPhotoLast(); ?>" alt="Avatar" title="Change the avatar">
                </div>
            </div>
            <h3><?= $models['person']->fullname; ?></h3>

            <ul class="list-unstyled user_data">
                <li><i class="fa fa-map-marker user-profile-icon"></i> <?= $models['person']->getAddressText(); ?></li>
                <li><i class="fa fa-briefcase user-profile-icon"></i> <?= $models['person']->getPositionTitle(); ?></li>
                <li><i class="fa fa-briefcase user-profile-icon"></i> <?= $models['person']->getSectionTitle(); ?></li>
                <!--<li class="m-top-xs">-->
                <!--    <i class="fa fa-external-link user-profile-icon"></i>-->
                <!--    <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>-->
                <!--</li>-->
            </ul>

            <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
            </div>
<?php 
$this->registerJs("
$('#veiw_sidebar').on('affix.bs.affix', function(){
    var pl = $(this).closest('.profile_left');
    $(this).css({
        width: pl.width() + 'px',
        top: '10px'
    });
});
");
?>

        </div>
        
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6 animated flipInY">
                    <?php
                    $form = ActiveForm::begin();
                    $mkey = 'person';
                    $modals[$mkey] = Modal::begin([
                        'size' => Modal::SIZE_LARGE,
                        'header' => $models[$mkey]->fullname,
                        'headerOptions' => $modalOptions['header-options'],
                        'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                            Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</i></div>' . 
                            $modalOptions['form-buttons'],
                    ]);
                    // echo DetailView::widget(array_replace_recursive($detailViewConfig, [
                    //     // 'id' => 'detail-view-'.$mkey,
                    //     'model'=>$models[$mkey],
                    //     // 'panel'=>[
                    //     //     'heading'=> 'Basic',
                    //     // ],
                    //     'attributes'=> $this->context->detailViewAttributes('_detail-view-person', ['model' => $models[$mkey]]),
                    // ]));
                    echo $this->render('_form-person', ['model' => $models[$mkey], 'form' => $form]);
                    Modal::end();
                    ActiveForm::end();
                    ?>
                    <?php
                    XPanel::begin(
                        [
                            'header' => 'Basic',
                            'icon' => 'cog',
                            'customTools' => [
                                [
                                    'encode' => false,
                                    'label' => '<i class="fa fa-pencil"></i>',
                                    'linkOptions' => [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#'.$modals[$mkey]->id,
                                        'title' => Yii::t('yii', 'Update')
                                    ],
                                    'url' => '#',
                                ],
                            ],
                        ]
                    )
                    ?>
                    <?php
                    $fields = [
                        'citizen_id' => $models[$mkey]->citizen_id,
                        'title_id' => $models[$mkey]->title->name,
                        'fullname_th' => $models[$mkey]->fullname,
                        'fullname_en' => $models[$mkey]->getFullname('en'),
                        'gender' => $models[$mkey]->getGenderText(),
                        'tel' => $models[$mkey]->tel,
                        'phone' => $models[$mkey]->phone,
                        'birthday' => $models[$mkey]->birthday,
                    ];
                    ?>
                    <table class="table detail-view">
                        <tbody>
                        <?php foreach ($fields as $key => $value) : ?>
                        <tr>
                            <th><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                            <td class="green"><?= $value; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th class="aero"><?= Yii::t('andahrm', 'Last update'); ?></th>
                            <td class="green aero"><?= Yii::$app->formatter->asDateTime($models[$mkey]->updated_at); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <?php XPanel::end() ?>
                    
                </div>
                
                <div class="col-sm-6 set-height-as-left animated flipInY">
                    <?php
                    $form = ActiveForm::begin();
                    $mkey = 'detail';
                    $modals[$mkey] = Modal::begin([
                        'header' => 'Detail',
                        'size' => Modal::SIZE_LARGE,
                        'headerOptions' => $modalOptions['header-options'],
                        'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                            Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</i></div>' . 
                            $modalOptions['form-buttons'],
                    ]);
                    // echo DetailView::widget(array_replace_recursive($detailViewConfig, [
                    //     'model'=>$models[$mkey],
                    //     'attributes'=> $this->context->detailViewAttributes('_detail-view-detail', ['model' => $models[$mkey]]),
                    // ]));
                    echo $this->render('_form-detail', ['model' => $models[$mkey], 'modelSpouse' => $models['people-spouse'], 'form' => $form]);
                    Modal::end();
                    ActiveForm::end();
                    ?>
                    <?php
                    XPanel::begin(
                        [
                            'header' => 'Detail',
                            'icon' => 'cog',
                            'customTools' => [
                                [
                                    'encode' => false,
                                    'label' => '<i class="fa fa-pencil"></i>',
                                    'linkOptions' => [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#'.$modals[$mkey]->id,
                                        'title' => Yii::t('yii', 'Update')
                                    ],
                                    'url' => '#',
                                ],
                            ],
                        ]
                    )
                    ?>
                    <?php
                    $fields = [
                        'nationality_id' => $models[$mkey]->nationality->title,
                        'race_id' => $models[$mkey]->race->title,
                        'religion_id' => $models[$mkey]->religion->title,
                        'blood_group' => $models[$mkey]->blood_group,
                        'married_status' => $models[$mkey]->getStatusText(),
                    ];
                    ?>
                    <table class="table detail-view">
                        <tbody>
                        <?php foreach ($fields as $key => $value) : ?>
                        <tr>
                            <th><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                            <td class="green"><?= $value; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th class="aero"><?= Yii::t('andahrm', 'Last update'); ?></th>
                            <td class="green aero"><?= Yii::$app->formatter->asDateTime($models[$mkey]->updated_at); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php XPanel::end() ?>
                    
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Photo</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?= $this->render('view/photo', ['model' => $models['photos']]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php /*<div class="row">
                <?php $mkey = 'photos'; ?>
                <div class="col-sm-12">
                    <?php
                    XPanel::begin([
                        'header' => 'Photo',
                        'icon' => 'cog',
                    ])
                    ?>
                    <div class="row">
                    <?php foreach($models[$mkey] as $photo) : ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <div class="image view view-first">
                                    <?= Html::img($photo->getUploadUrl('image_cropped'), ['style' => 'width: 100%; display: block;', 'alt' => 'image']); ?>
                                    <div class="mask">
                                        <p><?= $photo->year; ?></p>
                                        <div class="tools tools-bottom">
                                            <a href="<?= $photo->getUploadUrl('image_cropped'); ?>" title="<?= Yii::t('andahrm', 'View') ?>" data-toggle="modal" data-target="#<?= $modalPreview->id; ?>"><i class="fa fa-eye"></i></a>
                                            <a href="<?= $photo->getUploadUrl('image'); ?>" target="_blank" title="<?= Yii::t('andahrm', 'Original') ?>"><i class="fa fa-picture-o"></i></a>
                                            <a href="<?= Url::to(['photo/update', 'id'=>$photo->user_id, 'year' => $photo->year]); ?>" class="btn-load-form" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Update') ?>"><i class="fa fa-pencil"></i></a>
                                            <a href="<?= Url::to(['delete', 'id'=>$photo->user_id, 'year' => $photo->year]); ?>" data-confirm="<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>" title="<?= Yii::t('andahrm', 'Delete') ?>" data-method="post"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption text-center">
                                    <h3><?= $photo->year; ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="image view view-first">
                                    <a href="#" class="btn btn-default btn-block btn-load-form" style="height:100%;font-size: -webkit-xxx-large;display: flex; align-items: center; justify-content: center; color:#26B99A;" data-toggle="modal" data-target="#<?= $modal->id; ?>" title="<?= Yii::t('andahrm', 'Create') ?>"><i class="fa fa-plus-circle"></i></a>
                                </div>
                                <div class="caption text-center">
                                    <h3><?= Yii::t('andahrm', 'Create') ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php XPanel::end(); ?>
                </div>
            </div>*/ ?>
            
                
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    $addresses = [
                        ['key' => 'address-contact', 'label' => Yii::t('andahrm/person', 'Contact')],
                        ['key' => 'address-register', 'label' => Yii::t('andahrm/person', 'Register')],
                        ['key' => 'address-birth-place', 'label' => Yii::t('andahrm/person', 'Birth Place')],
                    ];
                    $items = [];
                    foreach ($addresses as $key => $address) {
                        $items[] = $models[$address['key']];
                    }
                    ?>
                    
                    <?php
                    XPanel::begin([
                        'header' => 'Address',
                        'icon' => 'cog',
                    ])
                    ?>
                    
                    <?php
                    echo \yii\grid\GridView::widget([
                        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $items]),
                        'summary'=>false,
                        'columns' => [
                            [
                                'label' => Yii::t('andahrm', 'Type'),
                                'value' => function($model, $index) use ($addresses){
                                    return ucfirst($addresses[$index]['label']);
                                }
                            ],
                            //'number_registration',
                            [
                                'attribute' => 'addressText',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'postcode',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            //'phone',
                            //'fax',
                            [
                                'attribute' => 'move_in_date',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            //'move_out_date',
                            [
                                'value' => function($model, $index) use ($addresses, $modalOptions){
                                    $form = ActiveForm::begin();
                                    $mkey = $addresses[$index]['key'];
                                    $modals[$mkey] = Modal::begin([
                                        'header' => 'Address: '.$addresses[$index]['label'],
                                        'size' => Modal::SIZE_LARGE,
                                        'headerOptions' => $modalOptions['header-options'],
                                        'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                                            Yii::$app->formatter->asDateTime($model->updated_at) . '</i></div>' . 
                                            $modalOptions['form-buttons'],
                                    ]);
                                    
                                    echo $this->render('_form-address', ['model' => $model, 'form' => $form]);
                                    
                                    Modal::end();
                                    ActiveForm::end();
                                    
                                    return Html::a('<i class="fa fa-pencil"></i>', '#', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#'.$modals[$mkey]->id,
                                        'title' => Yii::t('yii', 'Update')
                                    ]);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                    ]);
                    ?>
                    <?php XPanel::end(); ?>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    $parents = [
                        ['key' => 'people-father', 'label' => Yii::t('andahrm/person', 'Father')],
                        ['key' => 'people-mother', 'label' => Yii::t('andahrm/person', 'Mother')],
                    ];
                    $items = [];
                    foreach ($parents as $key => $parent) {
                        $items[] = $models[$parent['key']];
                    }
                    ?>
                    
                    <?php
                    XPanel::begin([
                        'header' => 'Parents',
                        'icon' => 'cog',
                    ])
                    ?>
                    
                    <?php
                    echo \yii\grid\GridView::widget([
                        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $items]),
                        'summary'=>false,
                        'columns' => [
                            [
                                'label' => Yii::t('andahrm', 'Type'),
                                'value' => function($model, $index) use ($parents){
                                    return ucfirst($parents[$index]['label']);
                                }
                            ],
                            [
                                'attribute' => 'citizen_id',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'fullname',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'birthday',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'nationality.title',
                                'label' => Yii::t('andahrm/person', 'Nationality'),
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'race.title',
                                'label' => Yii::t('andahrm/person', 'Race'),
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'occupation',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'liveStatusText',
                                'label' => Yii::t('andahrm/person', 'Live Status Text'),
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'value' => function($model, $index) use ($parents, $modalOptions){
                                    $form = ActiveForm::begin();
                                    $mkey = $parents[$index]['key'];
                                    $modals[$mkey] = Modal::begin([
                                        'header' => $parents[$index]['label'],
                                        'size' => Modal::SIZE_LARGE,
                                        'headerOptions' => $modalOptions['header-options'],
                                        'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                                            Yii::$app->formatter->asDateTime($model->updated_at) . '</i></div>' . 
                                            $modalOptions['form-buttons'],
                                    ]);
                                    
                                    echo $this->render('_form-people', ['model' => $model, 'form' => $form]);
                                    
                                    Modal::end();
                                    ActiveForm::end();
                                    
                                    return Html::a('<i class="fa fa-pencil"></i>', '#', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#'.$modals[$mkey]->id,
                                        'title' => Yii::t('yii', 'Update')
                                    ]);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                    ]);
                    ?>
                    <?php XPanel::end(); ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    XPanel::begin([
                        'header' => 'Childs',
                        'icon' => 'cog',
                    ])
                    ?>
                    
                    <?php
                    $mkey = 'people-childs';
                    $modals[$mkey] = Modal::begin([
                        'header' => Yii::t('andahrm/person', 'Childs'),
                        'size' => Modal::SIZE_LARGE,
                        'headerOptions' => $modalOptions['header-options'],
                    ]);
                    
                    echo '';
                                    
                    Modal::end();
                    
                    $this->registerJs("
$('#{$modals[$mkey]->id}').on('show.bs.modal', function (e) {
    var invoker = $(e.relatedTarget);
    var modal = $(this);
    if(typeof invoker.attr('role') != 'undefined'){
        modal.find('.modal-body').html('Loading...');
        $.ajax({
            url: invoker.attr('href'),
            success: function(data){
                modal.find('.modal-body').html(data);
            }
        });
    }
})
                    ");
                    
                    $childDataProvider = new \yii\data\ActiveDataProvider([
                        'query' => $models['person']->getPeopleChilds(),
                    ]);
                    echo \yii\grid\GridView::widget([
                        'dataProvider' => $childDataProvider,
                        'summary'=>false,
                        'columns' => [
                            [
                                'attribute' => 'citizen_id',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'fullname',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'birthday',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'nationality.title',
                                'label' => Yii::t('andahrm/person', 'Nationality'),
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'race.title',
                                'label' => Yii::t('andahrm/person', 'Race'),
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'occupation',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'liveStatusText',
                                'label' => Yii::t('andahrm/person', 'Live Status Text'),
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'header' => Html::a('<i class="fa fa-plus"></i>', ['child-create', 'person_id' => $models['person']->user_id], [
                                    'class' => 'btn btn-success btn-xs', 
                                    'title' => Yii::t('andahrm/person', 'Add Child'),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#'.$modals[$mkey]->id,
                                    'role' => 'child'
                                ]),
                                'buttons' => [
                                    'update' => function ($url, $model) use ($models, $modals, $mkey){
                                        return Html::a('<span class="fa fa-pencil"></span>', ['child-update', 'id' => $model->id, 'person_id' => $models['person']->user_id], [
                                            'title' => Yii::t('andahrm/person', 'Update Child'),
                                            'role' => 'child',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#'.$modals[$mkey]->id,
                                        ]);
                                    }
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) use ($models) {
                                    if ($action === 'delete') {
                                        return ['child-delete', 'id' => $model->id, 'person_id' => $models['person']->user_id];
                                    }
                                },
                            ],
                        ],
                    ]);
                    ?>
                    <?php XPanel::end(); ?>
                </div>
            </div><!-- end row -->
            
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    XPanel::begin([
                        'header' => 'Educations',
                        'icon' => 'cog',
                    ])
                    ?>
                    
                    <?php
                    $mkey = 'educations';
                    $modals[$mkey] = Modal::begin([
                        'header' => Yii::t('andahrm/person', 'Educations'),
                        'size' => Modal::SIZE_LARGE,
                        'headerOptions' => $modalOptions['header-options'],
                    ]);
                    
                    echo '';
                                    
                    Modal::end();
                    
                    $this->registerJs("
$('#{$modals[$mkey]->id}').on('show.bs.modal', function (e) {
    var invoker = $(e.relatedTarget);
    var modal = $(this);
    if(typeof invoker.attr('role') != 'undefined'){
        modal.find('.modal-body').html('Loading...');
        $.ajax({
            url: invoker.attr('href'),
            success: function(data){
                modal.find('.modal-body').html(data);
            }
        });
    }
})");
                    
                    $educationDataProvider = new \yii\data\ActiveDataProvider([
                        'query' => $models['person']->getEducations(),
                    ]);
                    echo \yii\grid\GridView::widget([
                        'dataProvider' => $educationDataProvider,
                        'summary'=>false,
                        'columns' => [
                            [
                                'attribute' => 'year_start',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'year_end',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'level.title',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'degree',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'branch',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'institution',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'attribute' => 'country.title',
                                'contentOptions' => ['class' => 'green'],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'header' => Html::a('<i class="fa fa-plus"></i>', ['education-create', 'person_id' => $models['person']->user_id], [
                                    'class' => 'btn btn-success btn-xs', 
                                    'title' => Yii::t('andahrm/person', 'Add Education'),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#'.$modals[$mkey]->id,
                                    'role' => 'education'
                                ]),
                                'buttons' => [
                                    'update' => function ($url, $model) use ($models, $modals, $mkey){
                                        return Html::a('<span class="fa fa-pencil"></span>', ['education-update', 'id' => $model->id, 'person_id' => $models['person']->user_id], [
                                            'title' => Yii::t('andahrm/person', 'Update Child'),
                                            'role' => 'education',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#'.$modals[$mkey]->id,
                                        ]);
                                    }
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php XPanel::end(); ?>
                </div>
            </div><!-- end row -->
            
        </div>
    </div>
    
</div>

<?php $this->render('detail-view/_address-js'); ?>
<?php
$js[] = <<< JS
$(document).on('click', '.btn-modal-save', function(e){
    var form = $(this).closest('.modal').find('.modal-body form');
    form.trigger('submit');
});

$.each($('.set-height-as-left'), function(){
    var left_height = $(this).prev().find('.x_panel').outerHeight();
    $(this).find('.x_panel').css({
        height: left_height+'px'
    });
});
JS;

$this->registerJs(implode("\n", $js));



$this->registerCss("
table.table.detail-view{
    margin: 0;
}
table.table.detail-view th,
table.table.detail-view td{
    border: 0;
}
.panel_toolbox{
    min-width: initial;
}
.panel_toolbox>li>a{
    color: #5A738E;
}");


