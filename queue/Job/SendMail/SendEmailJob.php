<?php

namespace app\queue\Job\SendMail;

use Yii;
use yii\db\Exception;
use yii\queue\JobInterface;
use app\queue\Job\SendMail\SendMail;

class SendEmailJob implements JobInterface
{
    /**
     * @throws Exception
     */
    public function execute($queue)
    {
        $emails = Yii::$app->db->createCommand('SELECT username FROM user')->queryColumn();
        foreach ($emails as $email) {
            $job = new SendMail([
                'email' => $email,
            ]);
            Yii::$app->queue->push($job);
            Yii::info('Đã đưa công việc gửi email cho ' . $email . ' vào hàng đợi.', 'queue');
        }
    }
}
