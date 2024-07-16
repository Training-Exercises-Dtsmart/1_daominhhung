<?php

namespace app\modules\models;

use app\models\base\Product as BaseProduct;

class Product extends BaseProduct
{
    public function formName(): string
    {
        return '';
    }
    public function fields()
    {
        return array_merge(parent::fields(), ['category_name' => 'categoryName']);
    }
    public function getCategoryName()
    {
        return empty($this->category) ? $this->category->name : null;
    }
}
