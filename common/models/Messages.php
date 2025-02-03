<?php

namespace common\models;

use common\libraries\SmartNSP;
use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $group_id
 * @property int $sender_id
 * @property string $message
 * @property string|null $create_time
 *
 * @property Groups $group
 * @property User $sender
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'sender_id', 'message'], 'required'],
            [['group_id', 'sender_id'], 'integer'],
            [['message'], 'string'],
            [['create_time'], 'safe'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::class, 'targetAttribute' => ['group_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'message' => Yii::t('app', 'Message'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::class, ['id' => 'group_id']);
    }

    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }

    public static function getLastMesg($group_id)
    {
        $mesg = Messages::find()->where(['group_id' => $group_id])->orderBy(['id' => SORT_DESC])->one();
        return (!empty($mesg)) ? $mesg->message : '';
    }

    public function sendChatNotification()
    {
        $group_members = GroupMembers::find()->where(['group_id' => $this->group_id])->all();
        if (!empty($group_members)) {
            foreach ($group_members as $member) {
                if ($member->user_id == $this->sender_id) {
                    //NO NEED TO SEND NOTIFICATION To Sender
                    $title = 'Sender: ' . $this->sender->name;
                } else {
                    $title = 'Receiver: ' . $member->user->username;
                    $notificationService = new SmartNSP();
                    $notificationService->sendPush();
                    $notificationService->setHidden();
                    $notificationService->sendEmail(false);
                    $notificationService->setOnClickRedirect('chat');
                    $notificationService->createNotification('mybaby', $member->user_id, $title, 'Group #' . $this->group_id . ', Mesg: ' . $this->message);
                }

//                print_r($response);print_r(PHP_EOL);
            }
//            die('DONE');
        }
        return true;
    }

//ekrYNQMiaUwIljPs3kIUqI:APA91bHJufB7PszD0CSknIC9dXesPRrMz2VNN2B4d3qyz4ijwzvYyelvBk6sJ9mYqHbQFumPlX_NFoccingWqCUQJd3NyRcTCJeBDTcfWXM-WZHMfBrs4IY

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert ) {
            $this->sendChatNotification();
        }
    }

}
