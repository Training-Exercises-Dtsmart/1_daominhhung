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
            'except' => ['login','register','index'],
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
