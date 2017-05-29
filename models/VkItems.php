<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vk_items".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property string $category
 * @property string $url
 * @property string $photo
 * @property string $description
 * @property string $description_raw
 * @property integer $timestamp
 * @property string $hash
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
            [['user_id', 'group_id', 'category', 'url', 'photo', 'description', 'timestamp', 'hash'], 'required'],
            [['user_id', 'group_id', 'timestamp'], 'integer'],
            [['url', 'photo', 'description', 'description_raw'], 'string'],
            [['category', 'hash'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
            'category' => 'Category',
            'url' => 'Url',
            'photo' => 'Photo',
            'description' => 'Description',
            'description_raw' => 'Description Raw',
            'timestamp' => 'Timestamp',
            'hash' => 'Hash',
        ];
    }
}
