<?php

namespace app\modules\models;

use app\models\base\Product as BaseProduct;


class Product extends BaseProduct
{
    public function fields()
    {
        return array_merge(parent::fields(), ['categories_value' => 'categoriesValue', 'post_title' => 'postTitle']);
    }
    public function getCategoriesValue()
    {
        return $this->categories->value;
    }
    public function getPostTitle()
    {
        return $this->post->title;
    }
}
