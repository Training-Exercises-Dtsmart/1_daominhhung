<?php

namespace app\modules\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller as BaseController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimitInterface;
use yii\filters\RateLimiter;
class Controller extends BaseController implements RateLimitInterface
{
    const HTTP_CODE_ENABLE = 200;
    public int $rateLimit = 60;
    public $allowance;
    public $allowance_updated_at;
//    public function behaviors(): array
//    {
//        $behaviors = parent::behaviors();
//
//        $behaviors['rateLimiter'] = [
//            'class' => RateLimiter::class,
//            'enableRateLimitHeaders' => false,
//            'except' => ['login', 'register', 'index', 'search', 'location'],
//        ];
//
//        $behaviors['authenticator'] = [
//            'class' => HttpBearerAuth::class,
//            'except' => ['login','register','index', 'search', 'location','create-vnpay', 'vnpay-order', 'create-viet-qr'],
//        ];
//
//        $behaviors['access'] = [
//            'class' => AccessControl::class,
//            'only' => ['index', 'update', 'delete', 'create', 'logout'],
//            'rules' => [
//                [
//                    'allow' => true,
//                    'actions' => ['login', 'register', 'password-reset', 'location'],
//                    'roles' => ['?'],
//                ],
//                [
//                    'allow' => true,
//                    'actions' => ['index', 'logout', 'password-reset'],
//                    'roles' => ['@'],
//                ],
//                [
//                    'allow' => true,
//                    'actions' => ['create', 'update', 'delete'],
//                    'roles' => ['admin'],
//                ],
//                [
//                    'allow' => true,
//                    'actions' => ['create'],
//                    'roles' => ['author'],
//                ]
//            ],
//        ];
//        return $behaviors;
//    }

    public function getRateLimit($request, $action): array
    {
        return [$this->rateLimit, 60];
    }

    public function loadAllowance($request, $action): array
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
    }

    public function json($status = true, $data = [], $message = "", $code = self::HTTP_CODE_ENABLE): array
    {
        Yii::$app->response->statusCode = $code;
        return [
            "status" => $status,
            "data" => $data,
            "message" => $message,
            "code" => $code
        ];
    }
}
