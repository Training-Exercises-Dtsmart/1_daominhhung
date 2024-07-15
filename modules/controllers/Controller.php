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
            'except' => ['login','register'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete','sendmail','sendmailqueue'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['author'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'search', 'searchcategories', 'login', 'register'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['login', 'register'],
                    'roles' => ['?'],
                ],
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
