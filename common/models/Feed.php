<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feed".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $grade_id
 * @property string|null $caption
 * @property string|null $status
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property FeedComments[] $feedComments
 * @property FeedComments $topFeedComment
 * @property FeedLikes[] $feedLikes
 * @property Grade $grade
 * @property User $user
 * @property array $images
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'grade_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['caption'], 'string', 'max' => 500],
            [['status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'caption' => Yii::t('app', 'Caption'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[FeedComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedComments()
    {
        return $this->hasMany(FeedComments::class, ['feed_id' => 'id']);
    }

    /**
     * Gets query for [FeedComments].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTopFeedComment()
    {
        return $this->hasOne(FeedComments::class, ['feed_id' => 'id']);
    }

    /**
     * Gets query for [[FeedLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedLikes()
    {
        return $this->hasMany(FeedLikes::class, ['feed_id' => 'id']);
    }

    /**
     * Gets query for [[Grade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(Grade::class, ['id' => 'grade_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    function getImages() {
        return Image::readImage('feed', $this->id)['data'];
    }

    function toDetailedJson() {
        $creator = [
            'id' => $this->user_id,
            'image_url' => $this->user->imageUrl,
            'title' => $this->user->name,
        ];

        $comments = [];
        foreach ($this->feedComments as $comment) {
            $comments[] = $comment->toDetailedJson();
        }
        $likes = [];
        foreach ($this->feedLikes as $like) {
            $likes[] = $like->toDetailedJson();
        }

        $data = [
            'id' => $this->id,
            'caption' => $this->caption,
            'images' => $this->images,
            'creator' => $creator,
            'create_time' => $this->update_time,
            'actions' => [],
            'top_comment' => empty($this->topFeedComment) ? null : $this->topFeedComment->toDetailedJson(),
            'comments' => $comments,
            'likes' => $likes,
            'is_liked' => $this->isLikedByUser(),
        ];

        return $data;
    }

    function toggleLike($studentId = null) {
        $user = User::findById();
        $fl = $user->getFeedLikes()
            ->andWhere(['feed_id' => $this->id]);

        if ($user->role == 'parent') {
            $fl = $fl->andWhere(['student_id' => $_POST['student_id'] ?? 0]);
        }

        $fl = $fl->one();

        if (!empty($fl)) {
            return $fl->delete();
        }

        $fl = new FeedLikes();
        $fl->user_id = $user->id;
        $fl->feed_id = $this->id;
        $fl->student_id = $studentId;
        return $fl->save(false);
    }

    /**
     * @param $userId
     * @return bool
     */
    function isLikedByUser($userId = null, $studentId = null) {
        $user = User::findById();
//        if ($userId == null) return false;

        $fl = FeedLikes::find()
            ->where(['user_id' => $user->id])
            ->andWhere(['feed_id' => $this->id]);

        if ($user->role == 'parent') {
            $fl = $fl->andWhere(['student_id' => $_POST['student_id'] ?? 0]);
        }

        $fl = $fl->one();

        return !empty($fl);
    }
}
