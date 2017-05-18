<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $parent_id
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['parent_id'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 64],
            [['name', 'alias'], 'unique', 'targetAttribute' => ['name', 'alias'], 'message' => 'The combination of Name and Alias has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'parent_id' => 'Parent ID',
        ];
    }
}
