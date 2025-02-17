<?php
namespace app\modules\intern\models\form;

use app\models\Order;
use Yii;
use yii\base\Exception;

class OrderForm extends Order
{
    const STATUS_PENDING = 0;
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['user_id', 'order_address'], 'required'],
        ]);
    }

    /**
     * @throws Exception
     */
    public function addOrder($orderData): bool
    {
        $user = Yii::$app->user->identity;
        $this->attributes = $orderData;
        $this->user_id = $user->id;

        if($this->validate())
        {
            $this->code_order = Yii::$app->security->generateRandomString(10);
            $this->date = date('Y-m-d H:i:s');
            $this->order_address = $orderData['order_address'] ?? '';

            $this->status = self::STATUS_PENDING;

            $orderDetail = new OrderDetailForm();
            $orderDetail->order_id = $this->id;

            if ($orderDetail->addOrderDetail($orderData))
            {
                $this->sendOrderSuccessEmail($this);
                $this->save();
                return true;
            } else {
                $this->addErrors($orderDetail->getErrors());
            }
        }
        return false;
    }
     protected function sendOrderSuccessEmail($order)
    {
        Yii::$app->mailer->compose('layouts/order', ['order' => $order])
            ->setFrom('no-reply@yourdomain.com')
            ->setTo($order->user->username)
            ->setSubject('Bill Order')
            ->send();
    }
}