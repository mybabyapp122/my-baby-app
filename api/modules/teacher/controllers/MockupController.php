<?php
namespace api\modules\teacher\controllers;

use common\libraries\CustomWidgets;
use yii\rest\Controller;
use Yii;

/**
 * Created by Mubashir
 * To be used for actions that are not ready on API side but ready on App side
 * September 2, 2024
 */

class MockupController extends Controller {

    public function actionIndex() {
        return 'At your service';
    }

}
