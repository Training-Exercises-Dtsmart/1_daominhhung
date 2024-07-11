<?php

namespace app\controllers;

use Yii;
use app\modules\Https_code;


class CaculateController extends Controller
{
    public function actionTotal()
    {
        //Post dữ liệu lên
        $formData = Yii::$app->request->post();
        //Check input soA , soB có tồn tại không , nếu có thì vô xử lý
        if (isset($formData['numberA']) && isset($formData['numberB'])) {
            $inputA = $formData['numberA'];
            $inputB = $formData['numberB'];
            //Check soA và soB có phải là số nguyên hay không
            if (!is_numeric($inputA) || !is_numeric($inputB)) {
                return $this->json(false, $$formData->getError(), 'Số A hoặc Số B không được chứa kí tự', HTTPS_CODE::BADREQUEST_CODE);
            }
            $total = $inputA + $inputB;
            return $this->json(true, $total, 'succes', HTTPS_CODE::SUCCESS_CODE);
        }
            return $this->json(false, $formData->getError(), 'Thiếu thông tin soA hoặc soB', HTTPS_CODE::BADREQUEST_CODE);
    }
    public function actionDivide()
    {
        $formData = Yii::$app->request->post();
        if (isset($formData['soA']) && isset($formData['soB'])) {
            $inputA = $formData['soA'];
            $inputB = $formData['soB'];
            if (!is_numeric($inputA) || !is_numeric($inputB)) {
                return $this->json(false, $$formData->getError(), 'Số A hoặc Số B không là số nguyên', HTTPS_CODE::BADREQUEST_CODE);
            }
            $divide = $inputA / $inputB;
            return $this->json(true, $divide, 'succes', HTTPS_CODE::SUCCESS_CODE);
        }
        return $this->json(false, $formData->getError(), 'Thiếu thông tin soA hoặc soB', HTTPS_CODE::BADREQUEST_CODE);
    }
    public function actionAverage()
    {
        $formData = Yii::$app->request->post();
        if (isset($formData['number'])) {
            //Input nhập theo dạng ví dụ 2,3,4,5
            $numberForm = $formData['number'];
            //Dưới đây tách chuỗi ra mảng
            $numbers = explode(',', $numberForm);
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
            return $this->json(true, $average, 'succes', HTTPS_CODE::SUCCESS_CODE);
        }
        return $this->json(false, $formData->getError(), 'Thiếu thông tin nhapso', HTTPS_CODE::BADREQUEST_CODE);
    }
}
