<?php

namespace app\modules\models\form;

use app\models\Product;

class ProductForm extends Product
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['name', 'price', 'stock', 'description', 'user_id'], "required"],
        ]);
    }
}

