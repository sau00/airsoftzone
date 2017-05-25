<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $vk
 * @property string $phone
 * @property string $firstname
 * @property string $lastname
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vk'], 'integer'],
            [['phone', 'firstname', 'lastname'], 'string', 'max' => 45],
            [['vk'], 'unique'],
            [['phone'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vk' => 'Vk',
            'phone' => 'Phone',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
        ];
    }
}
