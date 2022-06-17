<?php

namespace app\base;

use yii\base\Component;

class BaseComponent extends Component
{
    public $model_class;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->model_class)) {
            throw new \Exception('Need model_class param');
        }
    }
    public function getModel($data = [])
    {
        $model = new $this->model_class;

        if ($data) {
            $model->load($data);
        }

        return $model;
    }
}