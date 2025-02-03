<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_ar
 * @property string|null $description
 * @property string|null $description_ar
 * @property int|null $sub_users
 * @property int|null $subscription_period
 * @property float|null $price
 * @property int|null $highlighted
 * @property string|null $upgrade_to
 * @property int|null $status
 * @property string|null $status_ex
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property User[] $users
 */
class Plan extends \yii\db\ActiveRecord
{

    CONST PLANS = [
        '1' => [
            'max_teachers' => 3,
            'availability_calculator' => true,
            'school_stats' => true,
            'teacher_access_management' => true,
            'parent_arrival_feature' => true,
            'generate_invoices_for_parents' => true,
        ],
        '2' => [
            'max_teachers' => 5,
            'availability_calculator' => true,
            'school_stats' => true,
            'teacher_access_management' => true,
            'parent_arrival_feature' => false,
            'generate_invoices_for_parents' => false,
        ],
        '3' => [
            'max_teachers' => 30,
            'availability_calculator' => true,
            'school_stats' => true,
            'teacher_access_management' => true,
            'parent_arrival_feature' => true,
            'generate_invoices_for_parents' => true,
        ]
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sub_users', 'subscription_period', 'highlighted', 'status'], 'integer'],
            [['price'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'name_ar', 'description', 'description_ar', 'upgrade_to', 'status_ex'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'name_ar' => Yii::t('app', 'Name Ar'),
            'description' => Yii::t('app', 'Description'),
            'description_ar' => Yii::t('app', 'Description Ar'),
            'sub_users' => Yii::t('app', 'Sub Users'),
            'subscription_period' => Yii::t('app', 'Subscription Period'),
            'price' => Yii::t('app', 'Price'),
            'highlighted' => Yii::t('app', 'Highlighted'),
            'upgrade_to' => Yii::t('app', 'Upgrade To'),
            'status' => Yii::t('app', 'Status'),
            'status_ex' => Yii::t('app', 'Status Ex'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['plan_id' => 'id']);
    }
}
