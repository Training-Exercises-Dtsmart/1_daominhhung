<?php
namespace app\modules\models\form;

use Yii;
use app\models\Order;
use yii\base\Exception;

class OrderForm extends Order
{
    const STATUS_PENDING = 0;
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['user_id'], 'required'],
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

        if($this->validate() && $this->save())
        {
            $this->code_order = Yii::$app->security->generateRandomString(10);
            $this->date = date('Y-m-d H:i:s');
            $this->order_address = $orderData['order_address'] ?? '';

            $this->status = self::STATUS_PENDING;
            $this->save();

            $orderDetail = new OrderDetailForm();
            $orderDetail->order_id = $this->id;
            if ($orderDetail->addOrderDetail($orderData))
            {
                $this->sendOrderSuccessEmail($this);
                return true;
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