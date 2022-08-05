<?php

namespace app\modules\admin\searchModels;

use app\models\Comments;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CommentsSearch extends Comments
{
    public $date_from;
    public $date_to;
    public $user;
    public $review;
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['message','user','review'], 'safe'],
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
        $query = Comments::find()->joinWith('users')->joinWith(['review' => function ($q) {
            $q->from('reviews');
        }]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => array_merge($dataProvider->getSort()->attributes, [
                'user' => [
                    'asc' => ['users.email' => SORT_ASC],
                    'desc' => ['users.email' => SORT_DESC],
                    'default' => SORT_DESC,
                ],
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
            'id' => $this->id,
//            'review_id' => $this->review_id,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);
        $query->andFilterWhere(['like', 'users.email', $this->user]);
        $query->andFilterWhere(['like', 'reviews.message', $this->review]);

        if (!empty($this->date_from) and !empty($this->date_to)) {
            $query->andFilterWhere(['>=', 'comments.date_add', $this->date_from])->andFilterWhere(['<=', 'comments.date_add', $this->date_to]);
        }

        return $dataProvider;
    }
}