<?php

namespace app\components;

use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageLoaderComponent extends Component
{
    private function saveUploadedImage(UploadedFile $file): string
    {
        $path = $this->genPathForFile($file);
        return $file->saveAs($path) ? $path : '';
    }

    private function genPathForFile(UploadedFile $file): string
    {
        FileHelper::createDirectory(\Yii::getAlias('@webroot/images/'));
        return \Yii::getAlias('@webroot/images/') . uniqid() . '.' . $file->extension;
    }

    public function loadImages($model)
    {
        $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
        foreach ($model->images as &$image) {
            if ($file = $component->saveUploadedImage($image)) {
                $image = basename($file);
            }
        }
        return true;
    }

}