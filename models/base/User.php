<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use \app\models\query\UserQuery;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $image
 * @property string $username
 * @property string $password
 * @property string $address
 * @property integer $phone
 * @property string $access_token
 * @property string $password_reset_token
 * @property string $deleted_at
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\CategoryPost[] $categoryPosts
 * @property \app\models\CategoryProduct[] $categoryProducts
 * @property \app\models\Order[] $orders
 * @property \app\models\Post[] $posts
 * @property \app\models\Product[] $products
 * @property \app\models\Review[] $reviews
 */
abstract class User extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'value' => (new \DateTime())->format('Y-m-d H:i:s'),
                        ];
        
    return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['phone', 'status'], 'integer'],
            [['deleted_at'], 'safe'],
            [['image', 'username', 'password', 'address', 'access_token', 'password_reset_token'], 'string', 'max' => 255]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'image' => 'Image',
            'username' => 'Username',
            'password' => 'Password',
            'address' => 'Address',
            'phone' => 'Phone',
            'access_token' => 'Access Token',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'status' => 'Status',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(\app\models\CategoryPost::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProducts()
    {
        return $this->hasMany(\app\models\CategoryProduct::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(\app\models\Order::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(\app\models\Post::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\app\models\Product::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(\app\models\Review::class, ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(static::class);
    }
}
