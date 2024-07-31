<?php

namespace app\modules\models\form;

use Yii;
use app\models\OrderDetail;
use app\modules\models\Product;
use yii\db\Exception;

class OrderDetailForm extends OrderDetail
{
    const STATUS_PENDING = 0;
    const PAYMENT_CASH = 1;
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'required'],
        ]);
    }

    /**
     * @throws Exception
     */
    public function addOrderDetail($orderData): bool
    {
        if (isset($orderData['product_id']) && isset($orderData['quantity'])) {
            $productIds = explode(',', $orderData['product_id']);
            $quantities = explode(',', $orderData['quantity']);

            foreach ($productIds as $index => $productId) {
                $quantity = $quantities[$index];
                $orderDetail = new OrderDetailForm();
                $orderDetail->order_id = $this->order_id;
                $orderDetail->product_id = $productId;

                $product = Product::findOne($productId);
                if ($product) {
                    if ($product->stock < $quantity) {
                        $this->addErrors((array)'Quantity is less than Stock Product');
                        return false;
                    } else {
                        $product->stock -= $quantity;
                    }
                    $orderDetail->price = $product->price;
                }

                $orderDetail->quantity = $quantity;
                $orderDetail->payment = self::STATUS_PENDING;
                $orderDetail->status = self::STATUS_PENDING;

                if (!$orderDetail->validate()) {
                    $this->addErrors($orderDetail->getErrors());
                    return false;
                }

                if (!$orderDetail->save()) {
                    $this->addErrors($orderDetail->getErrors());
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}