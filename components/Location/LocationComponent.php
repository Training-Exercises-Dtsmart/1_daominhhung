<?php
namespace app\components\Location;

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

        if ($httpcode) {
            return json_decode($response, true);
        }
        return false;
    }
}
