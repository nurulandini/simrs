<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataPasien;

/**
 * DataPasienSearch represents the model behind the search form about `app\models\DataPasien`.
 */
class DataPasienSearch extends DataPasien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nik', 'kelurahan_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nomor_hp', 'alamat'], 'safe'],
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
        $query = DataPasien::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'nik' => $this->nik,
            'tanggal_lahir' => $this->tanggal_lahir,
            'kelurahan_id' => $this->kelurahan_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'nomor_hp', $this->nomor_hp])
            ->andFilterWhere(['like', 'alamat', $this->alamat]);

        return $dataProvider;
    }
}
