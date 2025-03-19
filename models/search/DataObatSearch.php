<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataObat;

/**
 * DataObatSearch represents the model behind the search form of `app\models\DataObat`.
 */
class DataObatSearch extends DataObat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kategori_id', 'persediaan', 'satuan_id', 'harga_per_unit', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama', 'deskripsi', 'tanggal_kedaluwarsa'], 'safe'],
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
        $query = DataObat::find();

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
            'kategori_id' => $this->kategori_id,
            'tanggal_kedaluwarsa' => $this->tanggal_kedaluwarsa,
            'persediaan' => $this->persediaan,
            'satuan_id' => $this->satuan_id,
            'harga_per_unit' => $this->harga_per_unit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi]);

        return $dataProvider;
    }
}
