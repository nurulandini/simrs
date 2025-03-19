<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Manage extends Component
{
    /* function roleCheck
     ** $role = role user yang ingin diperiksa (string|array)
     ** $id = user id yang ingin diperiksa (string)
     ** return boolean;
    */
    public function roleCheck($role, $id = NULL)
    {
        if (!$id) $id = Yii::$app->user->getId();
        $roles = Yii::$app->authManager->getRolesByUser($id);
        $roles = array_keys($roles);

        if(is_array($roles))
        {
            if(is_array($role))
            {
                if(count(array_intersect($role, $roles)))
                {
                    return true;
                }
            }
            else
            {
                if(in_array($role, $roles))
                {
                    return true;
                }
            }
        }
        
        return false;
    }

    /* function roleDetail
     ** $role = role user yang ingin diperiksa (string)
     ** $id = user id yang ingin diperiksa (string)
     ** return (data|NULL);
    */
    public function roleDetail($role, $id = NULL)
    {
        if (!$id) $id = Yii::$app->user->getId();
        
        $data = \common\models\User::findOne($id);

        if ($role == 'Operator SKPD' && $this->roleCheck($role, $id)) {
            return \common\models\T90SotkSubUnit::findOne([
                'id' => $data->sub_unit_id,
            ]);
        }
        if ($role == 'Operator Lingkungan' && $this->roleCheck($role, $id)) {
            return \common\models\WilayahLingkungan::findOne([
                'id' => $data->lingkungan_id,
            ]);
        }
        if ($role == 'Operator Kelurahan' && $this->roleCheck($role, $id)) {
            return \common\models\WilayahKelurahan::findOne([
                'id' => $data->kelurahan_id,
            ]);
        }
        if ($role == 'Operator Kecamatan' && $this->roleCheck($role, $id)) {
            return \common\models\WilayahKecamatan::findOne([
                'id' => $data->kecamatan_id,
            ]);
        }
        if ($role == 'Anggota Dewan' && $this->roleCheck($role, $id)) {
            return \common\models\DprdAnggota::findOne([
                'id' => $data->anggota_dewan,
            ]);
        }
        if ($role == 'Operator Bidang Bappeda' && $this->roleCheck($role, $id)) {
            return \common\models\DataBidangBappeda::findOne([
                'id' => $data->bidang_bappeda,
            ]);
        }

        return NULL;
    }

    public function badgeTitle($status, $title = true)
    {
        $res = "";
        if ($status == 0) {
            $res = "<span class='badge badge-warning'>Sedang di proses (Tahap Verifikasi)</span>";
        } else if ($status == 10) {
            $res = "<span class='badge badge-success'>Proposal diterima</span><br><br><span class='badge badge-warning'>Operator akan mengirimkan informasi seputar jadwal rapat pertemuan melalui email Anda.</span>";
            if (!$title) {
                $res = "<span class='badge badge-warning'>Sedang di proses (Menunggu jadwal rapat)</span>";
            }
        } else if ($status == 1) {
            $res = "<span class='badge badge-danger'>Verifikasi Gagal, berkas tidak sesuai !</span>";
        } else if ($status == 19) {
            $res = "<span class='badge badge-primary'>Sedang Berjalan</span>";
        } else if ($status == 20) {
            $res = "<span class='badge badge-success'>Program telah selesai</span>";
        }

        return $res;
    }
}
