<?php
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\setting\models\Helper;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php
$request = Yii::$app->request;
$profile = Yii::$app->user->identity->profile;
$module = $this->context->module->id;
?>

<div class="row">
    <div class="col-md-4">
    <?php
$searchModel = new PersonSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->pagination->pageSize = Yii::$app->params['app-settings']['reading']['pagesize'];

echo $this->render('person', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);
?>
    </div>
    <div class="col-md-8">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <?php
        $request = Yii::$app->request;
        $menuItems = [];
        if ($request->get('id')) {
            $menuItems = [
                [
                    'label' => '<i class="fa fa-history"></i> ' . Yii::t('andahrm/person', 'Default'),
                    'url' => Helper::urlParams("/{$module}/default/update"),
                ],                    
                [
                    'label' => '<i class="fa fa-info-circle"></i>  ' . Yii::t('andahrm/person', 'Detail'),
                    'url' => Helper::urlParams("/{$module}/detail/update"),
                ],
                [
                    'label' => '<i class="fa fa-camera"></i>  ' . Yii::t('andahrm/person', 'Photo'),
                    'url' => Helper::urlParams("/{$module}/photo"),
                ], 
                [
                    'label' => '<i class="fa fa-child"></i>  ' . Yii::t('andahrm/person', 'Child'),
                    'url' => Helper::urlParams("/{$module}/child"),
                ], 
            ];
        }
        //$menuItems = Helper::filter($menuItems);

        //$nav = new Navigate();
        echo Menu::widget([
            'options' => ['class' => 'nav nav-tabs bar_tabs'],
            'encodeLabels' => false,
            //'activateParents' => true,
            //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
            'items' => $menuItems,
        ]);
        ?>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" aria-labelledby="profile-tab">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
