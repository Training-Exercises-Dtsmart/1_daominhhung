<?php
namespace app\modules\models\queue;

use Yii;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\queue\JobInterface;

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
