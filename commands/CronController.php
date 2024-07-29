<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionIndex()
    {
        Yii::info('Hi Minh Hùng', 'cron');
    }
}
