<?php
namespace app\modules\models\form;

use Yii;
use yii\base\Model;
use app\modules\models\User;
use yii\db\Exception;

class PasswordResetRequestForm extends Model
{
    const STATUS_NOT_DELETE = 0;
    public $email;

    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\modules\models\User',
                'targetAttribute' => 'username',
                'filter' => ['status' => self::STATUS_NOT_DELETE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function sendEmail(): bool
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => self::STATUS_NOT_DELETE,
            'username' => $this->email,
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
