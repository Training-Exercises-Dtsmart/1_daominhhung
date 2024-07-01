<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;

class CaculateController extends Controller
{
    public function actionTotal()
    {
        //Post dữ liệu lên
        $formData = Yii::$app->request->post();

        //Now là lấy ngày hôm nay theo format day-month-year
        $now = (new \DateTime())->format('d-m-Y');
        //Check input soA , soB có tồn tại không , nếu có thì vô xử lý
        if (isset($formData['soA']) && isset($formData['soB'])) {

            $inputA = $formData['soA'];
            $inputB = $formData['soB'];

            //Check soA và soB có phải là số nguyên hay không 
            if (!is_numeric($inputA) || !is_numeric($inputB)) {
                return [
                    'status' => 'false',
                    'message' => "Số A hoặc Số B không được chứa kí tự",
                ];
            }

            $total = $inputA + $inputB;

            return [
                'status' => 'true',
                'data' => 'Tính tổng ' . $inputA . ' + ' . $inputB . ' = ' . $total,
                'now' => $now,
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Thiếu thông tin soA hoặc soB',
            ];
        }
    }
    public function actionDivide()
    {
        $formData = Yii::$app->request->post();

        //Now là lấy ngày hôm nay theo format day-month-year
        $now = (new \DateTime())->format('d-m-Y');

        if (isset($formData['soA']) && isset($formData['soB'])) {

            $inputA = $formData['soA'];
            $inputB = $formData['soB'];

            if (!is_numeric($inputA) || !is_numeric($inputB)) {
                return [
                    'status' => 'false',
                    'message' => "Số A hoặc Số B không là số nguyên",
                ];
            }

            $divide = $inputA / $inputB;

            return [
                'status' => 'true',
                'data' => 'Chia ' . $inputA . ' cho ' . $inputB . ' = ' . $divide,
                'now' => $now,
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Thiếu thông tin soA hoặc soB',
            ];
        }
    }

    public function actionAverage()
    {
        $formData = Yii::$app->request->post();

        $now = (new \DateTime())->format('d-m-Y');

        if (isset($formData['Nhapso'])) {
            //Input nhập theo dạng ví dụ 2,3,4,5
            $nhapSo = $formData['Nhapso'];
            
            //Dưới đây tách chuỗi ra mảng
            $numbers = explode(',', $nhapSo);
            $total = 0;

            //foreach mảng ra rồi cộng lại
            foreach ($numbers as $number) {
                $total += intval($number);
            }

            $count = count($numbers);
            //Hàm tính trung bình
            $average = $count > 0 ? $total / $count : 0;
            //Làm tròn
            $average = round($average, 2);
            return [
                'status' => 'true',
                'data' => [
                    'input' => $nhapSo,
                    'output' => $average,
                    'now' => $now,
                ],
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Thiếu thông tin nhapso',
            ];
        }
    }
}
