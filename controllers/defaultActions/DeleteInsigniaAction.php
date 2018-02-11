<?php

namespace andahrm\person\controllers\defaultActions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use andahrm\insignia\models\InsigniaPerson;

class DeleteInsigniaAction extends Action {

    //public $findModel;

    public function run($user_id, $insignia_type_id) {
        $model = InsigniaPerson::find()
                ->where(['user_id' => $user_id, 'insignia_type_id' => $insignia_type_id]);
        if ($model->exists()) {
            if ($model->one()->delete()) {
                if (Yii::$app->request->isAjax && $step) {
                    return $this->redirect(['create', 'id' => $user_id, 'step' => $step]);
                } elseif (Yii::$app->request->isAjax) {
                    return ['success' => true, 'result' => $model];
                } else {
                    Yii::$app->getSession()->setFlash('saved', [
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Delete completed.')
                    ]);
                    return $this->controller->redirect(['view-prestige', 'id' => $user_id]);
                }
            }
        }
    }

}
