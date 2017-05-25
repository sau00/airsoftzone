<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vk_groups".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $albums
 * @property string $name
 */
class VkGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'albums', 'name'], 'required'],
            [['group_id'], 'integer'],
            [['albums'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'albums' => 'Albums',
            'name' => 'Name',
        ];
    }
}
