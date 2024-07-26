<?php

namespace app\models;

use \app\models\base\CategoryProduct as BaseCategoryProduct;

/**
 * This is the model class for table "categories".
 */
class Category extends BaseCategoryProduct
{
    public function formName()
    {
        return "";
    }
}
