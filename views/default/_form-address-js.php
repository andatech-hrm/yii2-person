<?php
use yii\helpers\Url;
?>
<?php
$js[] = <<< JS
$(document).on('change', '.address-pane .local-region input:radio', function(e){
    var input = $(this);
    var tabPane = input.closest('div.address-pane');
    var inputProvince = tabPane.find('div.addr-province select');
    var inputAmphur = tabPane.find('div.addr-amphur select');
    var inputTumbol = tabPane.find('div.addr-tumbol select');
    var oldProvince = input.closest('.address-pane').find('input[name="oldProvince"]');
    var selected = '';
    inputProvince.text("");
    inputAmphur.text("");
    inputTumbol.text("");
    $.ajax({
        url: input.closest('.local-region').data('province-json'),
        data: {'region_id': input.val() },
        dataType: 'json',
        success: function(data){
            $.each(data, function( index, value ) {
                selected = '';
                if (oldProvince.val() == index) {
                    selected = ' selected';
                }
			    inputProvince.append("<option value='" + index + "'" + selected + "> " + value + "</option>");
			});
            inputProvince.trigger('change');
        }
    });
});
JS;

$jsonUrl['amphur'] = Url::to(['/setting/local-amphur/json']);
$js[] = <<< JS
$(document).on('change', '.address-pane .addr-province select', function(e){
    var input = $(this);
    var tabPane = input.closest('div.address-pane');
    var inputProvince = tabPane.find('div.addr-province select');
    var inputAmphur = tabPane.find('div.addr-amphur select');
    var inputTumbol = tabPane.find('div.addr-tumbol select');
    var oldAmphur = input.closest('.address-pane').find('input[name="oldAmphur"]');
    var selected = '';
    inputAmphur.text("");
    inputTumbol.text("");
    $.ajax({
        url: "{$jsonUrl['amphur']}",
        data: {'province_id': input.val() },
        dataType: 'json',
        success: function(data){
            $.each(data, function( index, value ) {
                selected = '';
                if (oldAmphur.val() == index) {
                    selected = ' selected';
                }
			    inputAmphur.append("<option value='" + index + "'" + selected + "> " + value + "</option>");
			});
            inputAmphur.trigger('change');
        }
    });
})
JS;

$jsonUrl['tambol'] = Url::to(['/setting/local-tambol/json']);
$js[] = <<< JS
$(document).on('change', '.address-pane .addr-amphur select', function(e){
    var input = $(this);
    var tabPane = input.closest('div.address-pane');
    var inputProvince = tabPane.find('div.addr-province select');
    var inputAmphur = tabPane.find('div.addr-amphur select');
    var inputTumbol = tabPane.find('div.addr-tumbol select');
    var oldTambol = input.closest('.address-pane').find('input[name="oldTambol"]');
    var selected = '';
    inputTumbol.text("");
    $.ajax({
        url: "{$jsonUrl['tambol']}",
        data: {'amphur_id': input.val() },
        dataType: 'json',
        success: function(data){
            $.each(data, function( index, value ) {
                selected = '';
                if (oldTambol.val() == index) {
                    selected = ' selected';
                }
			    inputTumbol.append("<option value='" + index + "'" + selected + "> " + value + "</option>");
			});
        }
    });
})
JS;

$js[] = <<< JS
$('.address-pane .local-region input:radio[checked]').trigger('change');
JS;


$js[] = <<< JS
$(document).on('click', '.btn-copy', function(e){
    e.preventDefault();
    var tabThis = $(this).closest('.tab-pane');
    var inputsThis = tabThis.find(':input').not('.btn-copy');
    var tabFrom = $('#' + $(this).data('from'));
    var inputsFrom = tabFrom.find(':input').not('.btn-copy');
    $.each(inputsThis, function(k, item){
        var attr = $(this).attr('data-name');
        if (typeof attr !== typeof undefined && attr !== false) {
        var name = $(this).data('name');
        var value = tabFrom.find(':input[data-name="' + name + '"]').val();
        $(this).val(value);
         console.log(tabFrom.find(':input[data-name="' + name + '"]').val());
        }
    });
});
JS;


$this->registerJs(implode("\n", $js));
?>