<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Thanh toán thất bại';
?>

<div class="payment-failed">
    <h1>Thanh toán thất bại</h1>
    <p>Đã xảy ra lỗi khi thanh toán đơn hàng của bạn. Vui lòng thử lại sau.</p>
    <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-primary">Quay lại trang chủ</a>
</div>

<style>
    .payment-failed {
        text-align: center;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #f8d7da;
        border-radius: 5px;
        background-color: #f8d7da;
        color: #721c24;
    }

    .payment-failed h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .payment-failed p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .payment-failed .btn {
        padding: 10px 20px;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
    }

    .payment-failed .btn:hover {
        background-color: #0056b3;
    }
</style>
