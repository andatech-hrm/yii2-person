
<table class="table-print" repeat_header="1" repeat_footer="1">
     <thead>
            <tr class="">
                <th class="text-center" style="width: 2cm;border:none;" colspan="6">
                    <p class="text-center" ><b>
                        <!--๑๑. การได้รับโทษทางวินัย-->
                        <?=Yii::t('andahrm/person','13. Position and salary rate.')?>
                    </b></p>
                </th>
            </tr>
            <tr class="header-labels">
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Adjust Date'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/position-salary', 'Title'); ?></th>
                <th class="text-center"><?= Yii::t('andahrm/position-salary', 'Position Id'); ?></th>
                <th class="text-center" style="width: 2cm;"><?= Yii::t('andahrm/position-salary', 'Level'); ?></th>
                <th class="text-center" style="width: 3cm;"><?= Yii::t('andahrm/position-salary', 'Salary'); ?></th>
                <th class="text-center cell-right" style="width: 5cm;"><?= Yii::t('andahrm/position-salary', 'Edoc ID'); ?></th>
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
                    <td class="cell-right" ><?= $model->edoc->codetitlePrint; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php 
                for($i=0;$i<=($rowNum[3]-count($models));$i++) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cell-right"></td>
                </tr>
            <?php endfor; ?>
        </tbody>
        <tfoot>
            <tr class="">
                <td class="text-center" style="width: 2cm;border:none;" colspan="6">
                    <p class="text-center" ><b>
                        <!--๑๑. การได้รับโทษทางวินัย-->
                        <?=Yii::t('andahrm/person','13. Position and salary rate.')?>
                    </b></p>
                </td>
            </tr>
        </tfoot>
    </table>
