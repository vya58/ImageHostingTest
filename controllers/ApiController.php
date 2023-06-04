<?php

namespace app\controllers;

use yii\web\Response;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
