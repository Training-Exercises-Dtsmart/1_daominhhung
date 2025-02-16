<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use \app\models\query\CompleteJobQuery;

/**
 * This is the base-model class for table "complete_job".
 *
 * @property integer $id
 * @property integer $job_id
 * @property resource $job_data
 * @property integer $completed_at
 * @property string $status
 */
abstract class CompleteJob extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complete_job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['job_id', 'job_data', 'completed_at'], 'required'],
            [['job_id', 'completed_at'], 'integer'],
            [['job_data'], 'string'],
            [['status'], 'string', 'max' => 255]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'job_data' => 'Job Data',
            'completed_at' => 'Completed At',
            'status' => 'Status',
        ]);
    }

    /**
     * @inheritdoc
     * @return CompleteJobQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompleteJobQuery(static::class);
    }
}
