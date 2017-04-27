<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $city
 * @property integer $shipping
 * @property string $description
 * @property string $vkpidaid
 * @property string $vk_image
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'description', 'vkpidaid', 'vk_image'], 'required'],
            [['user_id', 'shipping'], 'integer'],
            [['description', 'vk_image'], 'string'],
            [['title', 'city', 'vkpidaid'], 'string', 'max' => 255],
            [['vkpidaid'], 'unique'],
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
            'title' => 'Title',
            'city' => 'City',
            'shipping' => 'Shipping',
            'description' => 'Description',
            'vkpidaid' => 'Vkpidaid',
            'vk_image' => 'Vk Image',
        ];
    }
}
