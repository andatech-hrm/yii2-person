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
use andahrm\setting\models\Helper;
// use kartik\widgets\Select2;
// use kuakling\datepicker\DatePicker;
// use andahrm\setting\models\WidgetSettings;


$this->title = Yii::t('andahrm/person', 'Information');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->fullname, 'url' => ['view', 'id' => $models['person']->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;
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
    'form-buttons' => Html::resetButton('<i class="fa fa-recycle"></i> '.Yii::t('andahrm','Reset'), ['class' => 'btn btn-default']) . Html::submitButton('<i class="fa fa-save"></i> '.Yii::t('andahrm','Save'), ['class' => 'btn btn-primary btn-modal-save']),
    'header-options' => [
        'class' => 'bg-primary',
        'style' => 'border-top-left-radius:5px; border-top-right-radius:5px;'
    ]
];

// echo Yii::$app->formatter->asDate(date('Y-m-d'), 'php:d/m/Y');
?>

<div class="profile-default-index">
    <div class="row">
        <div class="col-sm-6 animated flipInY">
            <?php
            $form = ActiveForm::begin();
            $mkey = 'person';
            $modals[$mkey] = Modal::begin([
                'size' => Modal::SIZE_LARGE,
                'header' => '<i class="fa fa-info-circle"></i> ' . Yii::t('andahrm/person', 'Information'),
                'headerOptions' => $modalOptions['header-options'],
                'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                    Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</i></div>' . 
                    $modalOptions['form-buttons'],
            ]);
            echo $this->render('_form-person', ['model' => $models[$mkey], 'form' => $form]);
            Modal::end();
            ActiveForm::end();
            ?>

            <?php
            XPanel::begin(
                [
                    'header' => Yii::t('andahrm/person', 'Information'),
                    'icon' => 'info-circle',
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
                'birthday' => Yii::$app->formatter->asDate($models[$mkey]->birthday),
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
                
        <div class="col-sm-6 animated flipInY">
            <?php
            $form = ActiveForm::begin();
            $mkey = 'detail';
            $modals[$mkey] = Modal::begin([
                'header' => '<i class="fa fa-info-circle"></i> ' . Yii::t('andahrm/person', 'Information'),
                'size' => Modal::SIZE_LARGE,
                'headerOptions' => $modalOptions['header-options'],
                'footer' => '<div class="pull-left aero"><i>' . Yii::t('andahrm', 'Last Update') . ': ' . 
                    Yii::$app->formatter->asDateTime($models[$mkey]->updated_at) . '</i></div>' . 
                    $modalOptions['form-buttons'],
            ]);
            echo $this->render('_form-detail', ['model' => $models[$mkey], 'modelSpouse' => $models['people-spouse'], 'form' => $form]);
            Modal::end();
            ActiveForm::end();
            ?>

            <?php
            XPanel::begin(
                [
                    'header' => Yii::t('andahrm/person', 'Information'),
                    'icon' => 'info-circle',
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
                <?php if(intval($models['detail']->married_status) !== \andahrm\person\models\Detail::STATUS_SINGLE) : ?>
                <tr>
                    <td colspan="2"><h4 style="margin:0"><i class="fa fa-heart"></i> <?= Yii::t('andahrm/person', 'Spouse'); ?></h4></td>
                </tr>
                <?php
                $mkey = 'people-spouse';
                $fields = [
                    //'citizen_id' => $models[$mkey]->citizen_id,
                    'fullname' => $models[$mkey]->fullname,
                    //'birthday' => Yii::$app->formatter->asDate($models[$mkey]->birthday),
                    //'nationality_id' => $models[$mkey]->nationality->title,
                    //'race_id' => $models[$mkey]->race->title,
                    //'occupation' => $models[$mkey]->occupation,
                    'live_status' => $models[$mkey]->liveStatusText,
                ];
                ?>
                <?php foreach ($fields as $key => $value) : ?>
                <tr>
                    <th><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                    <td class="green"><?= $value; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <th class="aero"><?= Yii::t('andahrm', 'Last update'); ?></th>
                    <td class="green aero"><?= Yii::$app->formatter->asDateTime($models[$mkey]->updated_at); ?></td>
                </tr>
                </tbody>
            </table>
            
            <?php /* if(intval($models['detail']->married_status) !== \andahrm\person\models\Detail::STATUS_SINGLE) : ?>
            <div class="page-header" style="margin-top: 15px; margin-bottom:3px;">
                <div class="pull-right">
                    <?php
                    echo Html::a('<i class="fa fa-pencil"></i>', '#', [
                        'data-toggle' => 'modal',
                        'data-target' => '#'.$modals[$mkey]->id,
                        'title' => Yii::t('yii', 'Update') ]);
                    ?>
                </div>
                <h4 style="margin:0;"><i class="fa fa-heart"></i> <?= Yii::t('andahrm/person', 'Spouse'); ?></h4>
            </div>
            <?php
            $mkey = 'people-spouse';
            
            $fields = [
                //'citizen_id' => $models[$mkey]->citizen_id,
                'fullname' => $models[$mkey]->fullname,
                //'birthday' => Yii::$app->formatter->asDate($models[$mkey]->birthday),
                //'nationality_id' => $models[$mkey]->nationality->title,
                //'race_id' => $models[$mkey]->race->title,
                //'occupation' => $models[$mkey]->occupation,
                'live_status' => $models[$mkey]->liveStatusText,
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
                </tbody>
            </table>
            <?php endif; */ ?>
            <?php XPanel::end() ?>
                
        </div>
    </div>
            
    <div class="row">
        
        <div class="col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-image"></i> <?= Yii::t('andahrm/person', 'Photo'); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('view/photo', ['model' => $models['photos']]); ?>
                </div>
            </div>
        </div>
    </div>
            
            
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
                'header' => Yii::t('andahrm/person', 'Address'),
                'icon' => 'map-marker',
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
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'postcode',
                        'contentOptions' => ['class' => 'green'],
                    ],
                    //'phone',
                    //'fax',
                    [
                        'attribute' => 'move_in_date',
                        'format' => 'date',
                        'contentOptions' => ['class' => 'green'],
                    ],
                    //'move_out_date',
                    [
                        'value' => function($model, $index) use ($addresses, $modalOptions){
                            $form = ActiveForm::begin();
                            $mkey = $addresses[$index]['key'];
                            $modals[$mkey] = Modal::begin([
                                'header' => '<i class="fa fa-map-marker"></i> '.Yii::t('andahrm/person', 'Address').': '.$addresses[$index]['label'],
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
                'header' => Yii::t('andahrm/person', 'Parents'),
                'icon' => 'user-secret',
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
                        'format' => 'date',
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
                                'header' => '<i class="fa fa-user-secret"></i> ' . $parents[$index]['label'],
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
                'header' => Yii::t('andahrm/person', 'Childs'),
                'icon' => 'child',
            ])
            ?>
            
            <?php
            $mkey = 'people-childs';
            $modals[$mkey] = Modal::begin([
                'header' => '<i class="fa fa-child"></i> ' . Yii::t('andahrm/person', 'Childs'),
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
                        'format' => 'date',
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
                'header' => Yii::t('andahrm/person', 'Educations'),
                'icon' => 'graduation-cap',
            ])
            ?>
            
            <?php
            $mkey = 'educations';
            $modals[$mkey] = Modal::begin([
                'header' => '<i class="fa fa-graduation-cap"></i> ' . Yii::t('andahrm/person', 'Educations'),
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
            ?>
            <div class="table-responsive">
            <?php
            echo \yii\grid\GridView::widget([
                'dataProvider' => $educationDataProvider,
                'summary'=>false,
                'columns' => [
                    [
                        'attribute' => 'year_start',
                        'value' => 'yearStartBuddhist',
                        'contentOptions' => ['class' => 'green'],
                    ],
                    [
                        'attribute' => 'year_end',
                        'value' => 'yearEndBuddhist',
                        'contentOptions' => ['class' => 'green'],
                    ],
                    [
                        'attribute' => 'level.title',
                        'header' => Yii::t('andahrm/person', 'Level'),
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
                        'header' => Yii::t('andahrm/person', 'Country'),
                        'contentOptions' => ['class' => 'green'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
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
            </div>
            <?php XPanel::end(); ?>
        </div>
    </div><!-- end row -->
    
    
    <div class="row">
        <div class="col-sm-12">
            <?php
            XPanel::begin([
                'header' => Yii::t('andahrm/person', 'Roles'),
                'icon' => 'key',
            ])
            ?>
            <?php
            $mkey = 'roles';
            $roleList = $models['person']->roleList;
            $roles = Yii::$app->authManager->getRolesByUser($models['person']->user_id);
            $form = ActiveForm::begin();
            echo Html::checkBoxList('Roles', array_keys($roles), $roleList, ['separator' => '<br>']);
            echo Html::submitButton('<i class="fa fa-save"></i> '.Yii::t('andahrm/person', 'Save Roles'), ['class' => 'btn btn-primary btn-xs']);
            ActiveForm::end();
            ?>
            <?php XPanel::end(); ?>
        </div>
    </div><!-- end row -->
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


