<?php

namespace app\modules\intern\models;

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
    public function getCategoryName(): ?string
    {
        return isset($this->category) ? $this->category->name : null;
    }
}
