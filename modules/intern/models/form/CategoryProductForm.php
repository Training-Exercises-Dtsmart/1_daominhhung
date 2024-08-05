<?php

namespace app\modules\intern\models\form;


use app\models\CategoryProduct;

class CategoryProductForm extends CategoryProduct
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['user_id' , 'name'], 'required']
        ]);
    }
}