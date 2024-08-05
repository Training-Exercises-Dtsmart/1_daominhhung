<?php

namespace app\commands;

use app\modules\intern\controllers\VietQrController;
use Yii;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionIndex()
    {
        $controller = new VietQrController('email', Yii::$app);
        $result = $controller->actionIndex();

        Yii::info('Result from VietQrController: ' . print_r($result, true), 'cron');
        echo "Thông tin Bank: " . print_r($result, true) . "\n";
    }
}
