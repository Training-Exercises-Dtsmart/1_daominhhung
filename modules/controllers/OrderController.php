<?php

namespace app\modules\controllers;

use Yii;
use app\models\Order;
use app\modules\models\form\OrderForm;
use app\modules\HttpCode;
use yii\db\Exception;
use app\modules\models\search\Search;
use yii\helpers\Url;

class OrderController extends Controller
{
    public function actionIndex(): array
    {
        $order = Order::find();
        $searchModel = new Search();
        $param = Yii::$app->request->queryParams;
        $filter = Yii::$app->request->get('filter', 'code_order');
        $dataProvider = $searchModel->search($order, $param, $filter);

        if ($dataProvider->getModels()) {
            return $this->json(true, ['data' => $dataProvider->getModels()], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'errors', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionCreate(): array
    {
        $orderForm = new OrderForm();
        $orderData = Yii::$app->request->post();

        if($orderForm->addOrder($orderData) && $orderForm->save()){
            return $this->json(true, ['data' => $orderForm], 'Create order successfully', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, ['errors' => $orderForm->getErrors()],'Create order fail', HttpCode::ERRORCODE);
    }

    public function actionCreateVnpay(): void
    {
        $orderForm = new OrderForm();
        $orderData = Yii::$app->request->post();

        if ($orderForm->addOrder($orderData)) {
            if ($orderForm->save()) {
                $vnp_TmnCode = "PIEV8J2S";
                $vnp_HashSecret = "O3AEPIM3G0LHTBLP558JNEA5LHGF2UBT";
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = Url::to(['order/vnpay-return'], true);
                $vnp_TxnRef = $orderForm->id;
                $vnp_OrderInfo = "Thanh toan don hang #" . $orderForm->id;
                $vnp_OrderType = "other";
                $vnp_Amount = 10000 * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'NCB';
                $vnp_IpAddr = Yii::$app->request->userIP;

                $inputData = [
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                ];

                if (!empty($vnp_BankCode)) {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . $key . "=" . $value;
                    } else {
                        $hashdata .= $key . "=" . $value;
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                // Redirect to VNPAY payment page
                Yii::$app->response->redirect($vnp_Url)->send();
                Yii::$app->end();
            } else {
                Yii::error('Failed to save order: ' . print_r($orderForm->getErrors(), true));
            }
        } else {
            Yii::error('Failed to add order: ' . print_r($orderForm->getErrors(), true));
        }
        Yii::$app->response->send();
        Yii::$app->end();
    }
}