<?php

namespace app\modules\admin\searchModels;

use app\models\ReviewsImages;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ReviewImageSearch represents the model behind the search form of `app\searchModels\ReviewImage`.
 */
class ReviewsImagesSearch extends ReviewsImages
{

    public $image;
    public $date_from;
    public $date_to;
    public $review;


    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            [['id'], 'integer'],
            [['path','review'], 'safe'],
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
        $query = ReviewsImages::find()->joinWith(['review' => function ($q) {
            $q->from('reviews');
        }]);;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => array_merge($dataProvider->getSort()->attributes, [
                'review' => [
                    'asc' => ['reviews.message' => SORT_ASC],
                    'desc' => ['reviews.message' => SORT_DESC],
                    'default' => SORT_DESC,
                ],
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'path', $this->path]);
        $query->andFilterWhere(['like', 'reviews.message', $this->review]);

        if (!empty($this->date_from) and !empty($this->date_to)) {
            $query->andFilterWhere(['>=', 'reviews_images.date_add', $this->date_from])->andFilterWhere(['<=', 'reviews_images.date_add', $this->date_to]);
        }

        return $dataProvider;
    }
}
