<?php

namespace app\controllers;

use app\controllers\ApiController;
use app\models\Image;

class CountController extends ApiController
{
    public $modelClass = 'app\models\Image';
    
    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'getTotalCount'];

        return $actions;
    }

    /**
     * Метод получения количества загруженных картинок
     * 
     * @return array $count - массив, где значение ключа 'total' соответствует количеству картинок
     */
    public function getTotalCount(): array
    {
        $count['total'] = Image::find()->count();

        return $count;
    }
}
