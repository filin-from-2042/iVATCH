<?php

namespace app\modules\channels\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\channels\models\Channels;

/**
 * ChannelSearch represents the model behind the search form about `app\modules\channels\models\Channels`.
 */
class ChannelSearch extends Channels
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'image_id', 'tariff_id', 'subscribers_count'], 'integer'],
            [['title', 'description', 'tariff_start', 'tariff_end', 'subscribe_plan'], 'safe'],
            [['subscription_cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Channels::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'image_id' => $this->image_id,
            'tariff_id' => $this->tariff_id,
            'tariff_start' => $this->tariff_start,
            'tariff_end' => $this->tariff_end,
            'subscribers_count' => $this->subscribers_count,
            'subscription_cost' => $this->subscription_cost,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'subscribe_plan', $this->subscribe_plan]);

        return $dataProvider;
    }
}
