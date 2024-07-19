<?php
namespace app\modules\models\form;

use Yii;
use yii\base\Model;
use app\modules\https_code;
use app\modules\models\User;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\modules\models\User',
                'targetAttribute' => 'username', // Mapping 'email' to 'username' in database
                'filter' => ['status' => https_code::status_not_delete],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => https_code::status_not_delete,
            'username' => $this->email, // Matching 'email' to 'username' in database
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose('layouts/passwordResetToken-html', ['user' => $user])
            ->setFrom('huysanti123456@gmail.com')
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
