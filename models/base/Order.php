<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use \app\models\query\OrderQuery;

/**
 * This is the base-model class for table "order".
 *
 * @property integer $id
 * @property string $code_order
 * @property integer $user_id
 * @property string $order_address
 * @property string $date
 * @property integer $status
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\OrderDetail[] $orderDetails
 * @property \app\models\User $user
 */
abstract class Order extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
            [['user_id', 'status'], 'integer'],
            [['date', 'deleted_at'], 'safe'],
            [['code_order', 'order_address'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::class, 'targetAttribute' => ['user_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'code_order' => 'Code Order',
            'user_id' => 'User ID',
            'order_address' => 'Order Address',
            'date' => 'Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(\app\models\OrderDetail::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::class, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderQuery(static::class);
    }
}
