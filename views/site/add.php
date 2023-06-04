<?php

//use yii\bootstrap5\ActiveForm;
//use yii\bootstrap5\Html;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\UploadImagesForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var UploadImagesForm $model */

//$this->title = 'Images';

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'upload-images-form',
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <?= /* $form->field($imagesAddForm, 'imageTitle')->textInput(['autofocus' => true])*/ '' ?>
            <?= $form->field($imagesAddForm, 'files[]')->fileInput(['multiple' => true, 'class' => 'new-file form-label', 'placeholder' => 'Добавить изображение']); ?>


            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>