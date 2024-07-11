<?php
namespace app\modules\controllers;

use Yii;
use app\modules\Queue\SendEmailJob;
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
    public function actionSendmailqueue()
    {
        $job = new \app\modules\Queue\SendEmailJob();
        Yii::$app->queue->push($job);

        return ['status' => 'success', 'message' => 'Đã đưa công việc gửi email vào hàng đợi.'];

    }
}
