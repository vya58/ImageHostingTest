<?php

namespace app\src\services;

use yii\helpers\Inflector;
use app\models\Image;
use app\models\exceptions\ImageSaveException;

/**
 * Прикладной сервис для моделей класса Image 
 */
class ImageService
{
    /**
     * Метод создания превью загружаемого изображения
     * Взято здесь: https://yiiframework.ru/forum/viewtopic.php?t=53329
     * 
     * @param string $target - путь к оригинальному файлу
     * @param int $wmax - максимальная ширина
     * @param int $hmax - максимальная высота
     * @param string $ext - расширение файла
     * @param string $previewTitle - имя, под которым будет сохранено превью
     * 
     * @return void
     */
    private static function resizeImg(string $target, int $wmax, int $hmax, string $ext, string $previewTitle): void
    {
        $dest = Image::PREVIEW_IMAGE_UPLOAD_PATH . $previewTitle;

        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

        if (($wmax / $hmax) > $ratio) {
            $wmax = (int) ($hmax * $ratio);
        } else {
            $hmax = (int) ($wmax / $ratio);
        }

        $img = "";
        // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
        switch ($ext) {
            case ("gif"):
                $img = imagecreatefromgif($target);
                break;
            case ("png"):
                $img = imagecreatefrompng($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);
        }
        $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки

        if ($ext == "png") {
            imagesavealpha($newImg, true); // сохранение альфа канала
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127); // добавляем прозрачность
            imagefill($newImg, 0, 0, $transPng); // заливка  
        }

        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
        switch ($ext) {
            case ("gif"):
                imagegif($newImg, $dest);
                break;
            case ("png"):
                imagepng($newImg, $dest);
                break;
            default:
                imagejpeg($newImg, $dest);
        }
        imagedestroy($newImg);
    }

    /**
     * Метод добавления файла(файлов) нового задания
     * 
     * @param  array $files - массив объектов UploadedFile
     * 
     * @return bool
     * @throws ImageSaveException
     */
    public static function uploadImages(array $files): bool
    {
        if (is_iterable($files)) {
            foreach ($files as $file) {
                // Приведение названия изображения в нижний регистр и транслителирация на английский язык
                $addedImageTitle = Inflector::transliterate(mb_strtolower($file->baseName));

                // Проверка названия изображения на уникальность
                if (Image::find()->where(['title' => $addedImageTitle])->count()) {
                    // Уникальное имя файла в БД. Через '.', чтобы потом легле было отделить в случае необходимости
                    $addedImageTitle = $addedImageTitle . '.' . md5(microtime(true));
                }

                $addedImageExtension = $file->extension;

                $addedImage = $addedImageTitle . '.' . $addedImageExtension;

                $uploadedImg = Image::IMAGE_UPLOAD_PATH . $addedImage;

                $file->saveAs(Image::IMAGE_UPLOAD_PATH . $addedImage);

                self::resizeImg($uploadedImg, 146, 156, $addedImageExtension, $addedImage);

                $newImage = new Image();
                $newImage->title = $addedImageTitle;

                $newImage->extension = $addedImageExtension;

                if (!$newImage->save()) {
                    unlink($uploadedImg);
                    unlink(Image::PREVIEW_IMAGE_UPLOAD_PATH . $addedImage);
                    throw new ImageSaveException('Ошибка загрузки изображения');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Метод получения параметров для сортировки изображений
     * 
     * @param  array $get - массив с параметрами get-запроса
     * 
     * @return array $sortOptions - массив с параметрами сортировки
     */
    public static function getSortOptionsForImages(array $get): array
    {
        $sortOptions = [
            'orderBy' => 'title',
            'sort' => 'DESC',
        ];

        if (isset($get['created_at'])) {
            $sortOptions['orderBy'] = 'created_at';
        }

        if (isset($get[$sortOptions['orderBy']]) && 'asc' === $get[$sortOptions['orderBy']]) {
            $sortOptions['sort'] = 'ASC';
        }
        return $sortOptions;
    }
}
