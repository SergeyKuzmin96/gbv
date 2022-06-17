<?php

namespace app\modules\admin\models;

use app\models\Comment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CommentsSearchBase extends Comment
{
    public $date_from;
    public $date_to;
    public $user;
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id','review_id'], 'integer'],
            [['message','user'], 'safe'],
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
        $query = Comment::find()->joinWith('user');

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
            'review_id' => $this->review_id,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);
        $query->andFilterWhere(['like', 'users.email', $this->user]);
        if (!empty($this->date_from) and !empty($this->date_to)) {
            $query->andFilterWhere(['>=', 'comments.date_add', $this->date_from])->andFilterWhere(['<=', 'comments.date_add', $this->date_to]);
        }

        return $dataProvider;
    }
}