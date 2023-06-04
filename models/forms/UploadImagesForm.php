<?php

namespace app\models\forms;

use yii\base\Model;

class UploadImagesForm extends Model
{
    public $files;

    private const MAX_COUNT_IMAGES = 5;

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'files' => 'Файлы',
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['files', 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxFiles' => self::MAX_COUNT_IMAGES],
        ];
    }
}
