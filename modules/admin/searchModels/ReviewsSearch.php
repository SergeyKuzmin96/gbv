<?php

namespace app\modules\admin\searchModels;

use app\models\Reviews;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReviewsSearch extends Reviews
{
    /**
     * @var mixed|null
     */
    public $users;
    public $date_from;
    public $date_to;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id',], 'integer'],
            [['message', 'users'], 'safe'],
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
//        $query = Review::find()->joinWith(['reviewsImages','users','reviewsComments']);
        $query = Reviews::find()->joinWith('users');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => array_merge($dataProvider->getSort()->attributes, [
                'users' => [
                    'asc' => ['users.email' => SORT_ASC],
                    'desc' => ['users.email' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'User'
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
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);
        $query->andFilterWhere(['like', 'users.email', $this->users]);

        if (!empty($this->date_from) and !empty($this->date_to)) {
            $query->andFilterWhere(['>=', 'reviews.date_add', $this->date_from])->andFilterWhere(['<=', 'reviews.date_add', $this->date_to]);
        }
        return $dataProvider;
    }
}