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

    public $image_file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['user_id', 'category_id', 'city_id', 'alias', 'title', 'price'], 'required'],
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
            'category_id' => 'Категория',
            'city_id' => 'Город',
            'alias' => 'Alias',
            'title' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'shipping' => 'Доставка',
            'images' => 'Images',
            'time' => 'Time',
            'image_file' => 'Фотография'
        ];
    }

    public function upload()
    {
        if ($this->save()) {
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/' . $this->id)) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/' . $this->id);
            }

            $this->image_file->saveAs($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/' . $this->id . '/' . md5($this->image_file->baseName) . '.' . $this->image_file->extension);

            $item = self::findOne($this->id);
            $item->images = serialize([md5($this->image_file->baseName) . '.' . $this->image_file->extension]);
            echo $item->images;


            var_dump($item->validate());

            echo '<pre>';
            $errors = $item->errors;
            print_r($errors);
            echo '</pre>';

            var_dump($item->save());
        }

        return true;
    }
}
