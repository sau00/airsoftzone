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
 * @property string $author_id
 * @property string $group_id
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
            [['photo', 'description', 'url'], 'string'],
            [['group_id'], 'required'],
            [['md5', 'author_id'], 'string', 'max' => 45],
            [['group_id'], 'string', 'max' => 255],
            [['md5'], 'unique'],
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
        ];
    }
}
