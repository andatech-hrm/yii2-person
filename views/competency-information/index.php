<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii2assets\pdfjs\PdfJs;


$this->title =$menuItems[$file]['label'];
?>
<br/>

<div style="height:800px;">
    <?= PdfJs::widget([
        'width'=>'100%',
        'height'=> '800px',
        'url'=> Url::to("/uploads/competency/competency-{$file}.pdf",true)
    ]); ?>
</div>
