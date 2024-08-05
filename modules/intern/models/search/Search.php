<?php
namespace app\modules\intern\models\search;

use yii\data\ActiveDataProvider;

class Search extends \yii\base\Model
{
    public $search;
    const STATUS_ACTIVE = 0;

    public function rules(): array
    {
        return [
            [['search'], 'safe'],
        ];
    }

    public function search($model, $params, $filter): ActiveDataProvider
    {
        $this->load($params, '');

        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => $model,
            ]);
        }
        if ($this->search) {
            $model->andFilterWhere(['like', $filter, $this->search]);
        }

//        $model->andFilterWhere(['status' => self::STATUS_ACTIVE]);

        return new ActiveDataProvider([
            'query' => $model,
        ]);
    }
}
