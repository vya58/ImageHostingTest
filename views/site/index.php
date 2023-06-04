<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use \yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="row">
        <p class="col-lg-4 btn-outline-secondary">
            <a class="btn btn-outline-secondary" href="<?= Url::to(['site/index', 'title' => 'desc']); ?>">&#8595;</a>
            Сортировать по названию
            <a class="btn btn-outline-secondary" href="<?= Url::to(['site/index', 'title' => 'asc']); ?>">&#8593;</a>
        </p>

        <p class="col-lg-4 btn-outline-secondary">
            <a class="btn btn-outline-secondary" href="<?= Url::to(['site/index', 'created_at' => 'desc']); ?>">&#8595;</a>
            Сортировать по дате и времени загрузки
            <a class="btn btn-outline-secondary" href="<?= Url::to(['site/index', 'created_at' => 'asc']); ?>">&#8593;</a>
        </p>

        <p class="col-lg-4 btn-outline-secondary"><a class="btn btn-outline-secondary" href="<?= Url::to(['site/index']); ?>">Убрать сортировку</a></p>
    </div>
    <div class="body-content">
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_index',
                'itemOptions' => [
                    'tag' => false,
                ],
                'options' => [
                    'tag' => false,
                ],
            ]); ?>
        </div>
    </div>
</div>