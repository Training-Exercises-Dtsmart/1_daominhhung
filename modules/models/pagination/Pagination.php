<?php

namespace app\modules\models\pagination;

use yii\data\ActiveDataProvider;
use yii\rest\Serializer;

class Pagination
{
    public static  function getPagination($query, $pageSize, $sort)
    {
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => $sort,
                ],
            ],
        ]);
        $serializer = new Serializer(["collectionEnvelope" => "items"]);
        $data = $serializer->serialize($provider);

        return $data;
    }
}
