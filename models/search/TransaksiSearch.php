<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form of `app\models\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{
    public $diagnosa;
    public $pasien_id; // Untuk pencarian berdasarkan nama pasien
    public $nama_layanan;

    public function rules()
    {
        return [
            [['id', 'rekam_medis_id', 'biaya_layanan', 'biaya_obat', 'total_harga', 'status_pembayaran', 'metode_pembayaran', 'asuransi', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['pasien_id', 'tanggal', 'diagnosa', 'nama_layanan'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['diagnosa', 'pasien_id', 'nama_layanan']);
    }

    public function search($params)
    {
        $query = Transaksi::find()
            ->alias('t') // Alias utama untuk transaksi
            ->joinWith([
                'rekamMedis rm',
                'rekamMedis.rekamMedisDetails rmd',
                'rekamMedis.rekamMedisDetails.layanan lyn',
                'rekamMedis.dataResepDetails rd',
                'rekamMedis.skrinning.pendaftaran.pasien pasien', // Pastikan alias digunakan dengan benar
            ])
            ->groupBy('t.id')
            ->asArray(false);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter berdasarkan input pengguna
        $query->andFilterWhere([
            't.id' => $this->id,
            't.rekam_medis_id' => $this->rekam_medis_id,
            't.biaya_layanan' => $this->biaya_layanan,
            't.biaya_obat' => $this->biaya_obat,
            't.total_harga' => $this->total_harga,
            't.status_pembayaran' => $this->status_pembayaran,
            't.metode_pembayaran' => $this->metode_pembayaran,
            't.asuransi' => $this->asuransi,
            't.created_at' => $this->created_at,
            't.updated_at' => $this->updated_at,
            't.created_by' => $this->created_by,
            't.updated_by' => $this->updated_by,
        ]);

        // Filter berdasarkan diagnosa, nama pasien, dan nama layanan
        $query->andFilterWhere(['like', 'rm.diagnosa', $this->diagnosa]);
        $query->andFilterWhere(['like', 'pasien.nama', $this->pasien_id]); // Pastikan alias benar
        $query->andFilterWhere(['like', 'lyn.layanan', $this->nama_layanan]);

        return $dataProvider;
    }
}
