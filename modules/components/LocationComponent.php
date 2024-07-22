<?php
namespace app\modules\components;

use yii\base\Component;

class LocationComponent extends Component
{
    public function getDistricts()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://esgoo.net/api-tinhthanh/1/0.htm');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpcode == 200) {
            return json_decode($response, true);
        } else {
            throw new \yii\web\HttpException(500, 'Failed to fetch data from API');
        }
    }
}
