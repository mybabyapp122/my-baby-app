<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property int $id
 * @property string $name
 * @property string|null $create_time
 *
 * @property GroupMembers[] $groupMembers
 * @property Messages[] $messages
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * Gets query for [[GroupMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroupMembers()
    {
        return $this->hasMany(GroupMembers::class, ['group_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['group_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $user = Yii::$app->user->identity;
            if ($user->role == 'school') {
                $model = GroupMembers::find()->where(['group_id' => $this->id])->andWhere(['user_id' => $user->id])->one();
                //If not a member
                if (!$model) {
                    $model = new GroupMembers();
                    $model->user_id = $user->id;
                    $model->group_id = $this->id;
                    $model->save();
                }
            }
        }
    }

}
