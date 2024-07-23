<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $order app\models\Order */

$totalPrice = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            margin: 0;
            color: #333333;
        }
        .content {
            padding: 20px 0;
        }
        .content h2 {
            color: #333333;
        }
        .content p {
            color: #555555;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #dddddd;
            color: #777777;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Thank You for Your Order!</h1>
    </div>
    <div class="content">
        <h2>Order #<?= Html::encode($order->code_order) ?></h2>
        <p>Dear <?= Html::encode($order->user->username) ?>,</p>
        <p>Thank you for your purchase. We are currently processing your order and will send you a notification once it has been shipped.</p>
        <p>Here are the details of your order:</p>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order->orderDetails as $orderDetail): ?>
                    <?php
                    $product = $orderDetail->product;
                    $totalPrice += $orderDetail->totalPrice;
                    ?>
                    <tr>
                        <td><?= Html::encode($product->name) ?></td>
                        <td><?= Html::encode($orderDetail->totalQuantity) ?></td>
                        <td><?= Html::encode(number_format($product->price, 0, ',', '.') . ' VND') ?></td>
                        <td><?= Html::encode(number_format(($product->price) * ($orderDetail->totalQuantity), 0, ',', '.') . ' VND') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p><strong>Total Order: <?= Html::encode(number_format($totalPrice, 0, ',', '.') . ' VND') ?></strong></p>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Your Company. All rights reserved.
    </div>
</div>
</body>
</html>
