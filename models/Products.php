<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property string $img
 * @property float $quantity
 * @property string $description
 * @property string $color
 * @property int $categories_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'img', 'quantity', 'description', 'color', 'categories_id'], 'required'],
            [['price', 'categories_id'], 'integer'],
            [['img', 'description'], 'string'],
            [['quantity'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'img' => 'Img',
            'quantity' => 'Quantity',
            'description' => 'Description',
            'color' => 'Color',
            'categories_id' => 'Categories ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
