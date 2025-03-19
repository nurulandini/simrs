<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DataSkrinning;

/**
 * DataSkrinningSearch represents the model behind the search form of `app\models\DataSkrinning`.
 */
// class DataSkrinningSearch extends DataSkrinning
// {
//     public $nama_pasien;

//     public function rules()
//     {
//         return [
//             [['id', 'pegawai_id', 'tinggi', 'berat', 'denyut_jantung', 'saturasi_oksigen', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
//             [['pendaftaran_id', 'tekanan_darah', 'catatan', 'nama_pasien'], 'safe'],
//             [['suhu'], 'number'],
//         ];
//     }

//     public function search($params)
//     {
//         $query = DataSkrinning::find()
//             ->joinWith(['pendaftaran.pasien pasien', 'pegawai pegawai']); // Pastikan ada relasi ke pegawai

//         $dataProvider = new ActiveDataProvider([
//             'query' => $query,
//         ]);

//         $this->load($params);

//         if (!$this->validate()) {
//             return $dataProvider;
//         }

//         // Ambil `poli_id` dari user yang sedang login
//         $loggedInUserId = \Yii::$app->user->identity->id;
//         $data_pegawai = \app\models\User::findOne($loggedInUserId);

//         if ($data_pegawai) {
//             $poli_id = $data_pegawai->pegawai->poli_id;
//             $query->andWhere(['pegawai.poli_id' => $poli_id]);
//         }

//         $query->andFilterWhere([
//             'id' => $this->id,
//             'pendaftaran_id' => $this->pendaftaran_id,
//             'pegawai_id' => $this->pegawai_id,
//             'tinggi' => $this->tinggi,
//             'berat' => $this->berat,
//             'suhu' => $this->suhu,
//             'denyut_jantung' => $this->denyut_jantung,
//             'saturasi_oksigen' => $this->saturasi_oksigen,
//             'created_at' => $this->created_at,
//             'updated_at' => $this->updated_at,
//             'created_by' => $this->created_by,
//             'updated_by' => $this->updated_by,
//         ]);

//         $query->andFilterWhere(['like', 'tekanan_darah', $this->tekanan_darah])
//             ->andFilterWhere(['like', 'catatan', $this->catatan])
//             ->andFilterWhere(['like', 'pasien.nama', $this->nama_pasien]);

//         return $dataProvider;
//     }
// }

class DataSkrinningSearch extends DataSkrinning
{
    public $nama_pasien;
    public $poli_id; // Tambahkan variabel poli_id

    public function rules()
    {
        return [
            [['id', 'pegawai_id', 'tinggi', 'berat', 'denyut_jantung', 'saturasi_oksigen', 'created_at', 'updated_at', 'created_by', 'updated_by', 'poli_id'], 'integer'],
            [['pendaftaran_id', 'tekanan_darah', 'catatan', 'nama_pasien'], 'safe'],
            [['suhu'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = DataSkrinning::find()
            ->joinWith(['pendaftaran.pasien pasien', 'pegawai pegawai']); // Pastikan ada relasi pegawai

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // **Filter berdasarkan poli yang login**
        if ($this->poli_id) {
            $query->andWhere(['pegawai.poli_id' => $this->poli_id]);
        }

        // Filter lainnya tetap berjalan
        $query->andFilterWhere([
            'id' => $this->id,
            'pendaftaran_id' => $this->pendaftaran_id,
            'pegawai_id' => $this->pegawai_id,
            'tinggi' => $this->tinggi,
            'berat' => $this->berat,
            'suhu' => $this->suhu,
            'denyut_jantung' => $this->denyut_jantung,
            'saturasi_oksigen' => $this->saturasi_oksigen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'tekanan_darah', $this->tekanan_darah])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'pasien.nama', $this->nama_pasien]);

        return $dataProvider;
    }
}
