<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataPendaftaranPasien;

/**
 * DataPendaftaranPasienSearch represents the model behind the search form of `app\models\DataPendaftaranPasien`.
 */
class DataPendaftaranPasienSearch extends DataPendaftaranPasien
{
    public $nama_pasien;
    public $poli_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'poli_id'], 'integer'],
            [['pasien_id', 'nama_pasien', 'pegawai_id', 'tanggal_kunjungan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        // Ambil hanya kolom yang dibutuhkan
        $query = DataPendaftaranPasien::find()
            ->select(['data_pendaftaran_pasien.*', 'pasien.nama AS nama_pasien', 'pegawai.poli_id'])
            ->joinWith(['pasien pasien', 'pegawai pegawai']);

        // Pagination agar tidak semua data langsung ditampilkan
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // Tampilkan hanya 10 data per halaman
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id',
                    'tanggal_kunjungan',
                    'nama_pasien' => [
                        'asc' => ['pasien.nama' => SORT_ASC],
                        'desc' => ['pasien.nama' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter berdasarkan poli yang login
        if (!empty($this->poli_id)) {
            $query->andWhere(['poli_id' => $this->poli_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_kunjungan' => $this->tanggal_kunjungan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'pegawai.nama', $this->pegawai_id])
            ->andFilterWhere(['like', 'pasien.nama', $this->nama_pasien]);

        return $dataProvider;
    }
}
