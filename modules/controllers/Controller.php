<?php

namespace app\modules\controllers;

use Yii;
use yii\rest\Controller as BaseController;
use yii\filters\auth\HttpBearerAuth;

class Controller extends BaseController
{
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
