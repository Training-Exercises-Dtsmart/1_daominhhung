<?php

namespace app\commands;

use Yii;
use yii\base\InvalidRouteException;
use yii\console\Controller;
use yii\console\Exception;

class CronController extends Controller
{
    /**
     * @throws Exception
     * @throws InvalidRouteException
     */
    public function actionIndex()
    {
        $result = Yii::$app->runAction('api/v1/email/index');

        Yii::info('Result from EmailController: ' . print_r($result, true), 'cron');
    }
}
