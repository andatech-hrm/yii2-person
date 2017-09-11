<?php
use yii\bootstrap\Html;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
$controller = Yii::$app->controller->id;

?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel tile x_panel_success">
            <div class="x_title">
                <h2 ><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="alert alert-success" >
                    <strong>Holy guacamole!</strong> Best check yo self, you're not looking too good.
                 </div>
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
      
    </div>
</div>

<?php $this->endContent(); ?>
