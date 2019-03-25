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
// use andahrm\datepicker\DatePicker;
// use andahrm\setting\models\WidgetSettings;


$this->title = Yii::t('andahrm/person', 'Print') . ":" . $models['person']->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models['person']->fullname, 'url' => ['view', 'id' => $models['person']->user_id]];
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
    'form-buttons' => Html::resetButton('<i class="fa fa-recycle"></i> ' . Yii::t('andahrm', 'Reset'), ['class' => 'btn btn-default']) . Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('andahrm', 'Save'), ['class' => 'btn btn-primary btn-modal-save']),
    'header-options' => [
        'class' => 'bg-primary',
        'style' => 'border-top-left-radius:5px; border-top-right-radius:5px;'
    ]
];

// echo Yii::$app->formatter->asDate(date('Y-m-d'), 'php:d/m/Y');
?>

<div class="profile-default-index">
    <div class="row">
        <div class="col-xs-12">


            <?php
            XPanel::begin(
                    [
                        'header' => Yii::t('andahrm/person', 'Information'),
                        'icon' => 'info-circle',
                    ]
            )
            ?>

            <div class="row">
                <div class="col-xs-6">
                    <?php
                    $mkey = 'person';
                    $fields = [
                        'citizen_id' => $models[$mkey]->citizen_id,
                        'title_id' => $models[$mkey]->title->name,
                        'fullname_th' => $models[$mkey]->fullname,
                        'fullname_en' => $models[$mkey]->getFullname('en'),
                        'gender' => $models[$mkey]->getGenderText(),
                        'tel' => $models[$mkey]->tel,
                        'phone' => $models[$mkey]->phone,
                        'birthday' => Yii::$app->formatter->asDate($models[$mkey]->birthday),
                        'age' => $models[$mkey]->ageLabel,
                    ];
                    ?>
                    <table class="table detail-view"
                           data-toggle="table"
                           data-show-print="true"
                           >
                        <tbody>
                            <?php foreach ($fields as $key => $value) : ?>
                                <tr>
                                    <th nowrap><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                                    <td class="green" nowrap><?= $value; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-6">
                    <?php
                    $mkey = 'detail';
                    $fields = [
                        'nationality_id' => $models[$mkey]->nationality ? $models[$mkey]->nationality->title : null,
                        'race_id' => $models[$mkey]->race ? $models[$mkey]->race->title : null,
                        'religion_id' => $models[$mkey]->religion ? $models[$mkey]->religion->title : null,
                        'blood_group' => $models[$mkey]->blood_group,
                        'married_status' => $models[$mkey]->getStatusText(),
                    ];
                    ?>
                    <table class="table detail-view" data-toggle="table"
                           data-show-print="true">
                        <tbody>
                            <?php foreach ($fields as $key => $value) : ?>
                                <tr>
                                    <th nowrap><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                                    <td class="green" nowrap><?= $value; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (intval($models['detail']->married_status) !== \andahrm\person\models\Detail::STATUS_SINGLE) : ?>
                                <tr>
                                    <td colspan="2" ><h4 style="margin:0"><i class="fa fa-heart"></i> <?= Yii::t('andahrm/person', 'Spouse'); ?></h4></td>
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
                                        <th nowrap><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                                        <td class="green" nowrap><?= $value; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </div>


            <?php XPanel::end() ?>

        </div>


    </div>   


    <div class="row">
        <div class="col-xs-12">
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
                'summary' => false,
                'columns' => [
                    [
                        'label' => Yii::t('andahrm', 'Type'),
                        'value' => function($model, $index) use ($addresses) {
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
                ],
            ]);
            ?>
            <?php XPanel::end(); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
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
                //'showFooter' => true,
                'summary' => false,
                'columns' => [
                    [
                        'label' => Yii::t('andahrm', 'Type'),
                        'value' => function($model, $index) use ($parents) {
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
                ],
            ]);
            ?>
            <?php XPanel::end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            XPanel::begin([
                'header' => Yii::t('andahrm/person', 'Childs'),
                'icon' => 'child',
            ])
            ?>

            <?php
            $mkey = 'people-childs';

            $childDataProvider = new \yii\data\ActiveDataProvider([
                'query' => $models['person']->getPeopleChilds(),
            ]);
            echo \yii\grid\GridView::widget([
                'dataProvider' => $childDataProvider,
                'summary' => false,
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
                ],
            ]);
            ?>
            <?php XPanel::end(); ?>
        </div>
    </div><!-- end row -->

    <div class="row">
        <div class="col-xs-12">
            <?php
            XPanel::begin([
                'header' => Yii::t('andahrm/person', 'Educations'),
                'icon' => 'graduation-cap',
            ])
            ?>

            <?php
            $mkey = 'educations';

            $educationDataProvider = new \yii\data\ActiveDataProvider([
                'query' => $models['person']->getEducations(),
                'sort' => ['defaultOrder' => [
                        'year_start' => SORT_ASC,
                        'year_end' => SORT_ASC,
                    ]]
            ]);
            ?>
            <div class="table-responsive">
                <?php
                echo \yii\grid\GridView::widget([
                    'dataProvider' => $educationDataProvider,
                    'summary' => false,
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
                    ],
                ]);
                ?>
            </div>
            <?php XPanel::end(); ?>
        </div>
    </div><!-- end row -->

    <div class="row">
        <div class="col-xs-12">
            <?php
            XPanel::begin([
                'header' => Yii::t('andahrm/person', 'Position'),
                'icon' => 'briefcase',
            ])
            ?>
            <?= $this->render('print/_view-position', ['dataProvider' => $models['positions'],]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            XPanel::begin([
                'header' => Yii::t('andahrm/person', 'Development'),
                'icon' => 'cogs',
            ])
            ?>
            <?= $this->render('print/_view-development', ['dataProvider' => $models['developments']['dataProvider'], 'searchModel' => $models['developments']['searchModel']]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            XPanel::begin([
                'header' => Yii::t('andahrm/person', 'Prestige'),
                'icon' => 'trophy',
            ])
            ?>
            <?= $this->render('print/_view-prestige', ['dataProvider' => $models['prestige']['dataProvider'], 'searchModel' => $models['prestige']['searchModel']]) ?>
        </div>
    </div>

</div>

<?php
$js[] = <<< JS

$.each($('.set-height-as-left'), function(){
    var left_height = $(this).prev().find('.x_panel').outerHeight();
    $(this).find('.x_panel').css({
        height: left_height+'px'
    });
});
        
   $('table').attr('data-toggle','table').attr('data-show-print','true');
        
        
   window.print();
        
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


