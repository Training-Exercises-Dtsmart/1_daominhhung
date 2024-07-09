<?php

namespace app\modules\models\search;

use app\modules\models\Product;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{
    public $keyword;
    public function rules()
    {
        return [
            [['id', 'category_id', 'post_id'], 'integer'],
            [['name', 'created_at', 'updated_at', 'deleted_at', 'keyword'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Product::find()->joinWith('category');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, '');
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'product.name' => $this->name,
        ]);
        $query->andFilterWhere(["or",["LIKE", "category.name", $this->keyword]]);
        return $dataProvider;
    }
}
