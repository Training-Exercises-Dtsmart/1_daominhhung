<?php
/* @var $this yii\web\View */
/* @var $status string */

use yii\helpers\Html;

$this->title = 'Viet QR';
?>

<div class="payment-success">
    <h1>Thanh toán thành công</h1>
    <img src="https://api.vietqr.io/image/970416-13724041-GzagkHh.jpg?" alt="">
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
