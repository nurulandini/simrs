<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RealisasiPaketPekerjaan;

/**
 * RealisasiPaketPekerjaanSearch represents the model behind the search form about `app\models\RealisasiPaketPekerjaan`.
 */
class RealisasiPaketPekerjaanSearch extends RealisasiPaketPekerjaan
{
    public $deskripsi;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'detail_paket_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal','deskripsi'], 'safe'],
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
        $query = RealisasiPaketPekerjaan::find();

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
            'detail_paket_id' => $this->detail_paket_id,
            'tanggal' => $this->tanggal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }

    public function searchCombine($params)
    {
        $query = RealisasiPaketPekerjaan::find()
        ->joinWith('detailPaket')
        ->joinWith('detailPaket.paketPekerjaan paket')
        ->joinWith('detailPaket.paketPekerjaan.bidang bidang')
        ->joinWith('detailPaket.paketPekerjaan.kelurahan kelurahan')
        ->joinWith('detailPaket.paketPekerjaan.kelurahan.kecamatan kecamatan')
        ->joinWith('detailPaket.paketPekerjaan.lsm lsm')
        ->joinWith('detailPaket.paketPekerjaan.masyarakat masyarakat')
        ->joinWith('detailPaket.perusahaan perusahaan')
        ;

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
            'detail_paket_id' => $this->detail_paket_id,
            'tanggal' => $this->tanggal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->orFilterWhere(['like', 'paket.alamat', $this->deskripsi])
            ->orFilterWhere(['like', 'paket.asal_usulan', $this->deskripsi])
            ->orFilterWhere(['like', 'paket.status', $this->deskripsi])
            ->orFilterWhere(['like', 'paket.nama', $this->deskripsi])
            ->orFilterWhere(['like', 'paket.penerima', $this->deskripsi])
            ->orFilterWhere(['like', 'paket.deskripsi', $this->deskripsi])
            ->orFilterWhere(['like', 'bidang.nama', $this->deskripsi])
            ->orFilterWhere(['like', 'kelurahan.kelurahan', $this->deskripsi])
            ->orFilterWhere(['like', 'kecamatan.kecamatan', $this->deskripsi])
            ->orFilterWhere(['like', 'lsm.nama', $this->deskripsi])
            ->orFilterWhere(['like', 'masyarakat.nama', $this->deskripsi])
            ->orFilterWhere(['like', 'perusahaan.nama', $this->deskripsi])
            ;

        return $dataProvider;
    }
}
