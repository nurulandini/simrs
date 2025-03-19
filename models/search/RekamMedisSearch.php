<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataRekamMedis;

/**
 * RekamMedisSearch represents the model behind the search form of `app\models\DataRekamMedis`.
 */
class RekamMedisSearch extends DataRekamMedis
{
    public $nama_pasien; // Tambahkan atribut virtual

    public function rules()
    {
        return [
            [['id', 'skrinning_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['diagnosa', 'catatan', 'nama_pasien'], 'safe'], // Tambahkan 'nama_pasien'
        ];
    }

    public function search($params)
    {
        $query = DataRekamMedis::find();
        $query->joinWith(['skrinning.pendaftaran.pasien']); // Pastikan relasi sesuai

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nama_pasien'] = [
            'asc' => ['pasien.nama' => SORT_ASC],
            'desc' => ['pasien.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'diagnosa', $this->diagnosa])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'data_pasien.nama', $this->nama_pasien]); // Filter nama pasien

        return $dataProvider;
    }
}
