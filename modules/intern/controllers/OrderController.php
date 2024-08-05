<?php

namespace app\modules\intern\controllers;

use app\models\Order;
use app\models\Product;
use app\modules\intern\HttpCode;
use app\modules\intern\models\form\OrderForm;
use app\modules\intern\models\search\Search;
use Yii;
use yii\db\Exception;
use yii\web\Response;

class OrderController extends Controller
{
    const PAYMENT_ORDER_PAY = 'vnpay';
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

    public function actionCreateVnpay()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = Yii::$app->request->post();
        $productIds = $data['product_id'];
        $quantities = $data['quantity'];
        $address = $data['order_address'];
        $productIds = implode(',', $productIds);
        $productIds = explode(',', $productIds);
        $totalAmount = 0;
        foreach ($productIds as $productId) {
            $product = Product::findOne($productId);
            if ($product) {
                $totalAmount += $product->price;
            }
        }
        $amount = $totalAmount * 100;
        $vnp_TmnCode = 'VYX1GQZI';
        $vnp_HashSecret = '94S9HSGOE0TMT857CEQG7L4SSQSMEFPE';
        $vnp_ReturnUrl = 'http://localhost:8080/api/v1/order/vnpay-order';
        $vnp_ReturnUrl .= '?product_id=' . urlencode(implode(',', $productIds))
            . '&quantity=' . urlencode(implode(',', $quantities))
            . '&order_address=' . urlencode($address);

        $vnp_OrderInfo = 'Thanh toán hóa đơn';
        $vnp_OrderType = 'bill payment';
        $vnp_IpAddr = Yii::$app->request->userIP;
        $vnp_Locale = 'vn';
        $vnp_CreateDate = date('YmdHis');
        $vnp_TxnRef = date('YmdHis');

        $vnp_Params = [
            "vnp_Amount" => $amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_Version" => "2.1.0",
        ];
        ksort($vnp_Params);
        $query = http_build_query($vnp_Params);
        $secureHash = hash_hmac('sha512', $query, $vnp_HashSecret);
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_Url .= "?" . $query . "&vnp_SecureHash=" . $secureHash;
        return $this->json(true,['url' => $vnp_Url], 'success', HttpCode::SUCCESSCODE);
    }
    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionVnpayOrder(): string
    {
        $secureHash = Yii::$app->request->get('vnp_SecureHash');
        if ($secureHash) {
            $orderForm = new OrderForm();
            $orderData = [
                'product_id' => Yii::$app->request->get('product_id'),
                'quantity' => Yii::$app->request->get('quantity'),
                'order_address' => Yii::$app->request->get('order_address'),
                'payment_method' => self::PAYMENT_ORDER_PAY,
            ];
            if ($orderForm->addOrder($orderData) && $orderForm->save()) {
                Yii::warning($orderData);
            }
            Yii::$app->response->format = Response::FORMAT_HTML;
            return $this->render('@app/views/layouts/order/payment-success');
        }
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->render('@app/views/layouts/order/payment-failed');
    }
}