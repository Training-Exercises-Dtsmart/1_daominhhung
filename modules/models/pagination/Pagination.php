<?php

namespace app\modules\models\pagination;

use yii\data\ActiveDataProvider;
use yii\rest\Serializer;

class Pagination
{
    public static function getPagination($query, $pageSize, $sort, $search, $filter)
    {
        if ($search !== null) {
            $query->andFilterWhere(['like', $filter, $search]);
        }

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
        return (new Serializer(['collectionEnvelope' => 'items']))->serialize($provider);
    }
}
