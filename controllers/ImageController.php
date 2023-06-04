<?php

namespace app\controllers;

use app\controllers\ApiController;
use app\models\Image;
use yii\data\ActiveDataProvider;

class ImageController extends ApiController
{
    public $modelClass = 'app\models\Image';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'list',
    ];

    public function actions()
    {
        $actions = parent::actions();

        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * Метод, возвращающий провайдер данных с нужной пагинацией
     *
     * @return ActiveDataProvider
     */
    public function prepareDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Image::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
}
