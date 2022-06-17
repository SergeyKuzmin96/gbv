<?php

namespace app\components;

use app\base\BaseComponent;
use app\models\Images;
use yii\web\UploadedFile;

class ImagesComponent extends BaseComponent
{
    public function getModel($data = [])
    {
        /** @var Images $model */
        $model = new $this->model_class;
        if ($data) {
            $model->load($data);
            $model->images = UploadedFile::getInstances($model, 'images');
        }
        return $model;
    }
}