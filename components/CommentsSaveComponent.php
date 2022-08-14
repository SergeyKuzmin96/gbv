<?php

namespace app\components;

use yii\base\InvalidConfigException;
use yii\web\UploadedFile;

abstract class CommentsSaveComponent
{

    public function getModel($data = [])
    {
        $model = new $this->model_class;
        if ($data) {
            $model->load($data);
            $model->images = UploadedFile::getInstances($model, 'images');
            $model->user_id = \Yii::$app->user->getId();
        }
        return $model;
    }

    /**
     * @throws InvalidConfigException
     */
    public function createComment($model): bool
    {
        if ($model->validate() && $model->save()) {
            $component = new ImageLoaderComponent();
            if ($component->loadImages($model)) {

                $component->saveImages($model);
                return true;
            }
        }
        return false;
    }

}