<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \app\modules\intern\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2 style="color: #333;">Thay đổi mật khẩu</h2>
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>We received a request to reset your password for your account. If you did not request this, please ignore this email. Otherwise, you can reset your password using the following link:</p>
    <p style="text-align: center;">
        <a href="<?= $resetLink ?>" style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset Password</a>
    </p>
    <p>If the button above does not work, please copy and paste the following URL into your web browser:</p>
    <p style="word-break: break-all;"><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    <p>Thank you,</p>
    <p>The <?= Html::encode(Yii::$app->name) ?> Team</p>
</div>
