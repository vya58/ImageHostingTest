<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $title
 * @property string|null $loaded_in
 */
class Image extends \yii\db\ActiveRecord
{
    public const IMAGE_UPLOAD_PATH = 'uploads/images/';
    public const PREVIEW_IMAGE_UPLOAD_PATH = 'uploads/preview/';
    public const PREVIEW_WIDTH = 146;
    public const PREVIEW_HEIDTH = 156;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['extension'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'extension' => 'Расширение файла',
        ];
    }

    /**
     * Метод возврата полей в API
     * 
     */
    public function fields()
    {
        return [
            'id',
            'path' => function () {
                return $this->title . '.' . $this->extension;
            },
        ];
    }
}
