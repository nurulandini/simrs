<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataJadwalPegawai;

/**
 * DataJadwalPegawaiSearch represents the model behind the search form about `app\models\DataJadwalPegawai`.
 */
class DataJadwalPegawaiSearch extends DataJadwalPegawai
{
    public $pegawai_nama; // Tambahkan atribut untuk pencarian berdasarkan nama pegawai

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['pegawai_id', 'pegawai_nama', 'hari_kerja', 'shift', 'mulai', 'akhir'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = DataJadwalPegawai::find()
            ->joinWith('pegawai pegawai')
            ->groupBy('data_jadwal_pegawai.pegawai_id'); // Pastikan ada relasi dengan tabel pegawai

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Menambahkan pengurutan berdasarkan nama pegawai
        $dataProvider->sort->attributes['pegawai_nama'] = [
            'asc' => ['pegawai.nama' => SORT_ASC],
            'desc' => ['pegawai.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mulai' => $this->mulai,
            'akhir' => $this->akhir,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'hari_kerja', $this->hari_kerja])
            ->andFilterWhere(['like', 'pegawai.nama', $this->pegawai_nama]); // Gunakan atribut baru untuk pencarian nama pegawai

        return $dataProvider;
    }
}
