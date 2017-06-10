<?php
use yii\helpers\Html;
?>

<?php
$label = '';
if(isset($item['icon'])) {
    $label = Html::tag('i', null, ['class' => $item['icon']]);
}
$label .= ' ' . $item['label'];

$get = Yii::$app->request->get();
?>
<?php
//if(isset($get['step']))
if(isset($id)){
 echo Html::a($label, ['create','step'=>$index ,'id'=>$id]); 
}else{
 echo Html::a($label, ['create','step'=>$index ]); 
}
//echo Html::a($label, ['create']); 
?>
