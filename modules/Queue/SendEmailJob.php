<?php
namespace app\modules\Queue;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class SendEmailJob implements JobInterface
{
    public function execute($queue)
    {
        $emails = Yii::$app->db->createCommand('SELECT username FROM user')->queryColumn();
        foreach ($emails as $email) {
            $job = new SendMail([
                'email' => $email,
                'subject' => 'Xin Chào',
                'content' => 'Xin chào!' . ' ' . $email
            ]);
            Yii::$app->queue->push($job);
            Yii::info('Đã đưa công việc gửi email cho ' . $email . ' vào hàng đợi.', 'queue');
        }
    }
}
