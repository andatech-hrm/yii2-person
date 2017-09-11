
<table class="table-print" repeat_header="1" repeat_footer="1">
     <thead>
            <tr class="header-labels">
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Adjust Date'); ?></th>
                <th class="text-center" ><?= Yii::t('andahrm/position-salary', 'Title'); ?></th>
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Position ID'); ?></th>
                <th class="text-center" style="width: 1cm;"><?= Yii::t('andahrm/position-salary', 'Level'); ?></th>
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Salary'); ?></th>
                <th class="text-center cell-right" style="width: 3cm;"><?= Yii::t('andahrm/position-salary', 'Edoc ID'); ?></th>
            </tr>
        </thead>
        <tbody>
           
            <?php foreach($models as $key => $model): ?>
                <tr>
                    <td><?= Yii::$app->formatter->asDate($model->adjust_date); ?></td>
                    <td><?= $model->title; ?></td>
                    <td><?= $model->position->code; ?></td>
                    <td class="text-center"><?= $model->level; ?></td>
                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($model->salary); ?></td>
                    <td class="cell-right" ><?= $model->edoc->codeDateTitle; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php 
                $totalMod = count($models) % $rowNum[3];
                $count = $rowNum[3] - count($models);
                if(count($models)>$rowNum[3]){
                    $count = $rowNum[3] - $totalMod;
                }
                
                for($i=0;$i<=$count;$i++) : ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="cell-right">&nbsp;</td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
