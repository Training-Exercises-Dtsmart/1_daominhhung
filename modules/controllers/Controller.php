<?php

namespace app\modules\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller as BaseController;
use yii\filters\auth\HttpBearerAuth;

class Controller extends BaseController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login','register','index', 'search', 'location'],
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

    // Hàm trả về JSON response
    public function json($status = true, $data = [], $message = "", $code = 200): array
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
