<?php

use app\models\Image;
use yii\helpers\Html;

?>

<div class="col-lg-4">
    <h2><?= Html::encode($model->title) ?></h2>

    <p>Загружено: <?= Html::encode(Yii::$app->formatter->asDatetime($model->created_at, 'php:Y-m-d H:i:s')) ?></p>

    <a href='<?= Html::encode(Image::IMAGE_UPLOAD_PATH . $model->title . '.' . $model->extension) ?>' target="_blank">
        <img class="" src="<?= Html::encode(Image::PREVIEW_IMAGE_UPLOAD_PATH . $model->title . '.' . $model->extension) ?>" width="<?= Image::PREVIEW_WIDTH ?>" height="<?= Image::PREVIEW_HEIDTH ?>" alt="<?= Html::encode($model->title) ?>">
    </a>
</div>