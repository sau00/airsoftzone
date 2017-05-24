<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vk_items".
 *
 * @property integer $id
 * @property string $photo
 * @property string $description
 * @property string $url
 * @property string $md5
 * @property integer $author_id
 * @property integer $group_id
 * @property integer $timestamp
 */
class VkItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo', 'description', 'url', 'md5', 'author_id', 'group_id', 'timestamp'], 'required'],
            [['photo', 'description', 'url'], 'string'],
            [['author_id', 'group_id', 'timestamp'], 'integer'],
            [['md5'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'description' => 'Description',
            'url' => 'Url',
            'md5' => 'Md5',
            'author_id' => 'Author ID',
            'group_id' => 'Group ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
