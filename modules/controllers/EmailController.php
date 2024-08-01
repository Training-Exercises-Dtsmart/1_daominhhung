<?php

namespace app\modules\controllers;

use Yii;
use yii\web\Response;

class EmailController extends Controller
{
    public function actionIndex()
    {
        $response = Yii::$app->response;

        $imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
        $imapLogin = env('EMAIL_USER');
        $imapPassword = env('EMAIL_PASS');

        $mailbox = imap_open($imapPath, $imapLogin, $imapPassword);
        if(!$mailbox)
        {
            Yii::warning($mailbox);
        }
        if (!$mailbox) {
            return $this->asJson(['error' => 'Lỗi kết nối IMAP: ' . imap_last_error()]);
        }

        // Tìm kiếm email từ ngân hàng ACb
        $emails = imap_search($mailbox, 'FROM "ACB"');
        $emailData = [];

        if ($emails) {
            rsort($emails); // Sắp xếp từ mới đến cũ

            foreach ($emails as $email_number) {
                $overview = imap_fetch_overview($mailbox, $email_number, 0);

                $emailData[] = [
                    'subject' => $overview[0]->subject,
                    'from' => $overview[0]->from,
                    'date' => $overview[0]->date,
                ];
            }
        } else {
            $emailData = ['message' => 'Không có email nào từ ACb.'];
        }

        imap_close($mailbox);

        return $this->asJson($emailData);
    }
}