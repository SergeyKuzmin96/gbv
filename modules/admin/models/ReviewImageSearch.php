<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReviewImage;

/**
 * ReviewImageSearch represents the model behind the search form of `app\models\ReviewImage`.
 */
class ReviewImageSearch extends ReviewImage
{

    public $image;
    public $date_from;
    public $date_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'review_id'], 'integer'],
            [['path'], 'safe'],
            [['date_to', 'date_from'], 'date', 'format' => 'php:Y-m-d'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ReviewImage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'review_id' => $this->review_id,
        ]);

        $query->andFilterWhere(['like', 'path', $this->path]);

        if (!empty($this->date_from) and !empty($this->date_to)) {
            $query->andFilterWhere(['>=', 'reviews_images.date_add', $this->date_from])->andFilterWhere(['<=', 'reviews_images.date_add', $this->date_to]);
        }

        return $dataProvider;
    }
}
