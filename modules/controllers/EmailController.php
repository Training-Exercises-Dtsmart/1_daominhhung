<?php

namespace app\modules\controllers;

use Yii;
use app\modules\HttpCode;

class EmailController extends Controller
{
    public function actionIndex()
    {
        $imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
        $imapLogin = env('EMAIL_USER');
        $imapPassword = env("EMAIL_PASSWORD");

        $mailbox = imap_open($imapPath, $imapLogin, $imapPassword);
        if (!$mailbox) {
            return $this->asJson(['error' => 'IMAP connection fails: ' . imap_last_error()]);
        }
        $emails = imap_search($mailbox, 'FROM "ACB"');
        $count = 0;

        if ($emails) {
            rsort($emails);
            foreach ($emails as $email_number) {
                $overview = imap_fetch_overview($mailbox, $email_number, 0);
                $subject = $overview[0]->subject ?? '';

                if (stripos($subject, 'ACB-Dich vu bao so du tu dong') !== false) {
                    $message = imap_fetchbody($mailbox, $email_number, 1);
                    $parsedData = $this->parseEmailContent($message);

                    $emailData = [
                        'subject' => $subject,
                        'from' => $overview[0]->from,
                        'date' => $overview[0]->date,
                        'account' => $parsedData['account'],
                        'transaction' => $parsedData['transaction'],
                        'description' => $parsedData['description'],
                    ];

                    $count++;
                    if ($count >= 5) {
                        break;
                    }
                }
            }
        } else {
            $emailData = ['message' => 'Not found email ACB.'];
        }
        imap_close($mailbox);
        return $this->json(true, $emailData, 'success', HttpCode::SUCCESSCODE);
    }

    private function parseEmailContent($content): array
    {
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        $content = strip_tags($content);
        $content = preg_replace('/\s*=\s*/', '', $content);
        $content = preg_replace('/&[a-zA-Z0-9#]+;/u', '', $content);
        $content = preg_replace('/[\r\n]+/', ' ', $content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        preg_match('/ti khoản\s*(\d+)/i', $content, $accountMatches);
        preg_match('/Giao dịch mới nhất:(Ghi nợ|Ghi có)\s*([+-]?[\d,]+\.\d+\s*VND)/i', $content, $transactionMatches);
        preg_match('/Nội dung giao dịch:\s*([^\d]+)\s*(\d{6,})/', $content, $descriptionMatches);
        $description = preg_replace('/[-]+/', '', $descriptionMatches[1]);

        return [
            'account' => $accountMatches[1] ?? 'Not Found',
            'transaction' => $transactionMatches[2] ?? 'Not Found',
            'description' => $description ?? 'Not Found',
        ];
    }
}
