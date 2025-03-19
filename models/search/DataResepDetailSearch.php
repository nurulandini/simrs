<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataResepDetail;

/**
 * DataResepDetailSearch represents the model behind the search form of `app\models\DataResepDetail`.
 */
class DataResepDetailSearch extends DataResepDetail
{
    public $nama_pasien; // Properti untuk pencarian berdasarkan nama pasien

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rekam_medis_id', 'obat_id', 'jumlah', 'biaya', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['dosis', 'instruksi', 'nama_pasien'], 'safe'], // Tambahkan 'nama_pasien' ke aturan validasi
        ];
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
        $query = DataResepDetail::find()
            ->alias('d')
            ->joinWith(['rekamMedis.skrinning.pendaftaran.pasien p', 'rekamMedis.skrinning.pendaftaran.pegawai pg'])
            ->groupBy('d.rekam_medis_id'); // Mengelompokkan berdasarkan rekam_medis_id

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Tambahkan Sorting Nama Pasien
        $dataProvider->sort->attributes['nama_pasien'] = [
            'asc' => ['p.nama' => SORT_ASC],
            'desc' => ['p.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'rekam_medis_id' => $this->rekam_medis_id,
            'obat_id' => $this->obat_id,
            'jumlah' => $this->jumlah,
            'biaya' => $this->biaya,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        // Perbaikan filter berdasarkan nama pasien
        $query->andFilterWhere(['like', 'p.nama', $this->nama_pasien])
            ->andFilterWhere(['like', 'dosis', $this->dosis])
            ->andFilterWhere(['like', 'instruksi', $this->instruksi]);

        return $dataProvider;
    }
}
