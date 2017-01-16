<?php
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\person\models\Helper;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php
$request = Yii::$app->request;
$profile = Yii::$app->user->identity->profile;
$module = $this->context->module->id;
?>

<?= $content; ?>
<?php $this->endContent(); ?>
