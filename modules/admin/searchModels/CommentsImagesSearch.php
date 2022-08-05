<?php

namespace app\modules\admin\searchModels;

use app\models\CommentsImages;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommentImageSearch represents the model behind the search form of `app\searchModels\CommentImage`.
 */
class CommentsImagesSearch extends CommentsImages
{
    public $image;
    public $date_from;
    public $date_to;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['path', 'comment'], 'safe'],
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
        $query = CommentsImages::find()->joinWith(['comment' => function ($q) {
            $q->from('comments');
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
                'comment' => [
                    'asc' => ['comments.message' => SORT_ASC],
                    'desc' => ['comments.message' => SORT_DESC],
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
        ]);

        $query->andFilterWhere(['like', 'path', $this->path]);
        $query->andFilterWhere(['like', 'comments.message', $this->comment]);

        if (!empty($this->date_from) and !empty($this->date_to)) {
            $query->andFilterWhere(['>=', 'comments_images.date_add', $this->date_from])->andFilterWhere(['<=', 'comments_images.date_add', $this->date_to]);
        }
        return $dataProvider;
    }
}
