<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\src\service\ImageService;
use app\models\forms\UploadImagesForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\Image;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $get = Yii::$app->request->get();

        $query = Image::find();

        $sortOptions = ImageService::getSortOptionsForImages($get);
        $orderBy = $sortOptions['orderBy'];
        $sort = $sortOptions['sort'];

        if (isset($get[$orderBy])) {
            $query = $query->orderBy("{$orderBy} {$sort}");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', compact('dataProvider'));
    }

    /**
     * Метод добавления изображений в БД
     *
     * @return string
     */
    public function actionAdd(): string
    {
        $imagesAddForm = new UploadImagesForm();

        if (Yii::$app->request->getIsPost()) {
            $imagesAddForm->load(Yii::$app->request->post());
            $imagesAddForm->files = UploadedFile::getInstances($imagesAddForm, 'files');

            if ($imagesAddForm->validate()) {
                ImageService::uploadImages($imagesAddForm->files);
                $this->refresh();
            }
        }
        return $this->render('add', compact('imagesAddForm'));
    }
}
