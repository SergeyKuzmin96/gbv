<?php

namespace app\models;

use app\base\BaseModel;

class Images extends BaseModel
{
    public $images;

    public function rules(): array
    {
        return [
            ['images', 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 5]
        ];
    }
}