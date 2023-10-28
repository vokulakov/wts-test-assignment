<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "publications".
 *
 * @property int $postID
 * @property string $tittle
 * @property string $text
 * @property int $authorID
 * @property int $createdAt
 *
 * @property User $author
 */
class BasePublications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tittle', 'text', 'authorID', 'createdAt'], 'required'],
            [['text'], 'string'],
            [['authorID', 'createdAt'], 'integer'],
            [['tittle'], 'string', 'max' => 255],
            [['tittle'], 'unique'],
            [['authorID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['authorID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'postID' => 'Post ID',
            'tittle' => 'Tittle',
            'text' => 'Text',
            'authorID' => 'Author ID',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'authorID']);
    }
}
