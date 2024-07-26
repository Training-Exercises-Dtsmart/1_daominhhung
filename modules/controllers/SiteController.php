<?php
namespace app\modules\controllers;

use app\queue\Job\SendMail\SendEmailJob;
use Yii;

class SiteController extends Controller
{
    public function actionSendmail()
    {
        Yii::$app->mailer->compose()
            ->setFrom('no-reply@domain.com')
            ->setTo('daominhhung2203@gmail.com')
            ->setSubject('Xin chào')
            ->setTextBody('Hello')
            ->setHtmlBody('<b>HTML content</b>')
            ->send();
    }
    public function actionSendmailQueue(): array
    {
        $job = new SendEmailJob();
        Yii::$app->queue->push($job);

        return ['status' => 'success', 'message' => 'Add Queue Success'];

    }
}
