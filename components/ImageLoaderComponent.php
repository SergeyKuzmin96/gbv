<?php

namespace app\components;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

class ImageLoaderComponent
{
    private function saveUploadedImage(UploadedFile $file): string
    {
        $path = $this->genPathForFile($file);
        return $file->saveAs($path) ? $path : '';
    }

    /**
     * @throws Exception
     */
    private function genPathForFile(UploadedFile $file): string
    {
        FileHelper::createDirectory(\Yii::getAlias('@webroot/images/'));
        return \Yii::getAlias('@webroot/images/') . uniqid() . '.' . $file->extension;
    }

    public function loadImages($model): bool
    {
        foreach ($model->images as &$image) {
            if ($file = self::saveUploadedImage($image)) {
                $image = basename($file);
            }
        }
        return true;
    }

    public function saveImages(ActiveRecord $model)
    {
        foreach ($model->images as &$path) {
            $image = $model->getImagesModel();
            $image->path = $path;
            $image->save();
        }
    }

    public function getOneImage($path, $width = null, $height = null): string
    {
        if ($width == null) {
            $width = 50;
        }
        if ($height == null) {
            $height = 40;
        }

        return Html::img('/images/' . $path, ['width' => $width, 'height' => $height]);
    }

    public function deleteImagesFromServer(array $images){
        foreach ($images as $image) {
            unlink(Yii::getAlias('@webroot/images/') . $image['path']);
        }
    }

}