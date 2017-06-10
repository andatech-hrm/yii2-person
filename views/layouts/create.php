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
use kuakling\smartwizard\SmartWizardAsset;

use andahrm\person\PersonApi;

$asset = SmartWizardAsset::register($this);
$this->registerCssFile($asset->baseUrl.'/css/smart_wizard.css', ['depends' => ['\kuakling\smartwizard\SmartWizardAsset']]);
?>
<?php
// $profile = $user->profile;
// $person = Person::findOne($user->id);
//$person = PersonApi::instance(Yii::$app->request->get('id'));
// print_r($person);
// exit();
//$module = $this->context->module->id;

$wizardItems = [];
//$isNewRecord= $models['person']->isNewRecord;#true
foreach ($this->context->formSteps as $key => $step) {
    $wizardItems[$step['name']] = [
       'icon' => $step['icon'],
    'label' => 'Step - '.$step['name'].' <br /><small>'.$step['desc'].'</small>',
    ];
}
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>



<div class="sw-main sw-theme-default" id="person-wizard">
    
    <?php
    $step = Yii::$app->request->get('step');
    $step = $step==null?1:$step;
    echo Html::ul($wizardItems, ['item' => function($item, $index) use($step){
            $active = $index == $step?' active':'';
            $done = $index < $step?' done':'';
            return Html::tag('li', 
                $this->render('../layouts/_nav-item-default', ['item' => $item, 'index' => $index, 'widget' => $this,'id'=>$this->context->user_id]),
                ['class' => 'post'.$active.$done ]
            );
        }, 'class' => 'nav nav-tabs step-anchor'])?>
       
   
   
    <?= $content; ?>
  
   
    
</div>

<?php $this->endContent(); ?>

