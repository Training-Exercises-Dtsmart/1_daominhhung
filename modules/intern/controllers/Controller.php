<?php

namespace app\modules\intern\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller as BaseController;

class Controller extends BaseController
{
    const HTTP_CODE_ENABLE = 200;
    public string $allowance;
    public string $allowance_updated_at;
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login','register','index', 'search', 'location','create-vnpay', 'vnpay-order', 'create-viet-qr'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index', 'update', 'delete', 'create', 'logout'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['login', 'register', 'password-reset', 'location'],
                    'roles' => ['?'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'logout', 'password-reset'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['author'],
                ]
            ],
        ];
        return $behaviors;
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
