<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vk_groups".
 *
 * @property integer $id
 * @property string $vk_id
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
            [['vk_id', 'name'], 'required'],
            [['vk_id'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 255],
            [['vk_id'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vk_id' => 'Vk ID',
            'name' => 'Name',
        ];
    }
}
