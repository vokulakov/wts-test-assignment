<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BasePublications;

/**
 * PublicationsSearch represents the model behind the search form of `common\models\BasePublications`.
 */
class PublicationsSearch extends BasePublications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postID', 'authorID', 'createdAt'], 'integer'],
            [['tittle', 'text'], 'safe'],
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
        $query = BasePublications::find();

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
            'postID' => $this->postID,
            'authorID' => $this->authorID,
            'createdAt' => $this->createdAt,
        ]);

        $query->andFilterWhere(['like', 'tittle', $this->tittle])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
