<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $city_id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property integer $price
 * @property integer $shipping
 * @property string $images
 * @property string $time
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
            [['user_id', 'category_id', 'city_id', 'alias', 'title', 'images'], 'required'],
            [['user_id', 'category_id', 'city_id', 'price', 'shipping'], 'integer'],
            [['description', 'images'], 'string'],
            [['time'], 'safe'],
            [['alias'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 45],
            [['alias'], 'unique'],
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
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'alias' => 'Alias',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'shipping' => 'Shipping',
            'images' => 'Images',
            'time' => 'Time',
        ];
    }
}
