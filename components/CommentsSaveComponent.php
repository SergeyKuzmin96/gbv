<?php

namespace app\components;

use app\models\Images;
use yii\base\Component;

abstract class CommentsSaveComponent extends Component
{
    public $img_comp_class;
    public $img_comp;
    public $model_class;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->img_comp_class)) {
            throw new \Exception('Need img_comp_class param');
        } elseif (empty($this->model_class)) {
            throw new \Exception('Need model_class param');
        } else {
            $this->img_comp = \Yii::createObject([
                'class' => $this->img_comp_class
            ]);
        }
    }

    public function getModel($data = [])
    {
        $model = new $this->model_class;
        if ($data) {
            $model->load($data);
            $model->user_id = \Yii::$app->user->getId();
        }
        return $model;
    }


    public function createComment($model, Images $model_img): bool
    {
        if (!$model->validate() || !$model_img->validate()) {
            return false;
        }
        if (!$model->save()) {
            return false;
        } else {

            if (\Yii::$app->image_loader->loadImages($model_img)) {
                $this->img_comp->saveImages($model_img->images, $model->id);
            }
        }
        return true;
    }
}