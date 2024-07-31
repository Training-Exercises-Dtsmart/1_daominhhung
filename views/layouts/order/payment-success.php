<?php
/* @var $this yii\web\View */
/* @var $status string */

use yii\helpers\Html;

$this->title = 'Thanh toán thành công';
?>

<div class="payment-success">
    <h1>Thanh toán thành công</h1>
    <p>Đơn hàng của bạn đã được thanh toán thành công.</p>
    <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-primary">Quay lại trang chủ</a>
</div>

<style>
    .payment-success {
        text-align: center;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #d4edda;
        border-radius: 5px;
        background-color: #d4edda;
        color: #155724;
    }

    .payment-success h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .payment-success p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .payment-success .btn {
        padding: 10px 20px;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
    }

    .payment-success .btn:hover {
        background-color: #0056b3;
    }
</style>
