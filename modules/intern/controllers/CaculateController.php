<?php

namespace app\modules\intern\controllers;

use app\modules\intern\HttpCode;
use Yii;
use function PHPUnit\Framework\exactly;

class CaculateController extends Controller
{
    public function actionIndex(): array
    {
        $data = Yii::$app->request->post();

        $data = implode(',', $data);
        $data = explode(',', $data);

        $numberA = $data[0];
        $numberB = $data[1];

        if (is_numeric($numberA) && is_numeric($numberB)) {
            if (strlen($numberA) <= 255 && strlen($numberB) <= 255) {

                $a_len = strlen($numberA);
                $b_len = strlen($numberB);

                $result = 0;
                for ($i = 0; $i < $a_len; $i++) {
                    for ($j = 0; $j < $b_len; $j++) {
                        $digit_a = (int)substr($numberA, $a_len - 1 - $i, 1);
                        $digit_b = (int)substr($numberB, $b_len - 1 - $j, 1);
                        $partial_product = $digit_a * $digit_b * pow(10, $i + $j);
                        $result += $partial_product;
                    }
                }
                $result = number_format($result, 2, '.', '');
                return $this->json(true, $result, 'success', HttpCode::SUCCESSCODE);
            }
        }
        return $this->json(true, [], 'sai roi <3', HttpCode::BADREQUESTCODE);

    }
}