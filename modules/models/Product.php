<?php

namespace app\modules\models;

use app\models\base\Product as BaseProduct;


class Product extends BaseProduct
{
    public function fields()
    {
        return array_merge(parent::fields(), ['category_name' => 'categoryName', 'post_title' => 'postTitle']);
    }
    public function getCategoryName()
    {
        return isset($this->category) ? $this->category->name : null;
    }
    public function getPostTitle()
    {
        return $this->post->title;
    }
}
