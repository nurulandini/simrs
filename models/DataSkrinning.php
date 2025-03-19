<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "data_skrinning".
 *
 * @property int $id
 * @property int $pendaftaran_id
 * @property int $pegawai_id
 * @property int|null $tinggi
 * @property float|null $berat
 * @property string $tekanan_darah
 * @property float $suhu
 * @property int|null $denyut_jantung
 * @property int|null $saturasi_oksigen
 * @property string|null $catatan
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $status
 * 
 * @property User $createdBy
 * @property DataRekamMedis[] $dataRekamMedis
 * @property DataPegawai $pegawai
 * @property DataPendaftaranPasien $pendaftaran
 * @property User $updatedBy
 */
class DataSkrinning extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_skrinning';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendaftaran_id', 'pegawai_id', 'tekanan_darah', 'suhu'], 'required'],
            [['pendaftaran_id', 'pegawai_id', 'tinggi', 'denyut_jantung', 'saturasi_oksigen', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['berat', 'suhu'], 'number'],
            [['catatan'], 'string'],
            [['tekanan_darah'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['pendaftaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataPendaftaranPasien::class, 'targetAttribute' => ['pendaftaran_id' => 'id']],
            [['pegawai_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataPegawai::class, 'targetAttribute' => ['pegawai_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pendaftaran_id' => 'Pendaftaran ID',
            'pegawai_id' => 'Pegawai ID',
            'tinggi' => 'Tinggi',
            'berat' => 'Berat',
            'tekanan_darah' => 'Tekanan Darah',
            'suhu' => 'Suhu',
            'denyut_jantung' => 'Denyut Jantung',
            'saturasi_oksigen' => 'Saturasi Oksigen',
            'catatan' => 'Catatan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[DataRekamMedis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataRekamMedis()
    {
        return $this->hasMany(DataRekamMedis::class, ['skrinning_id' => 'id']);
    }

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(DataPegawai::class, ['id' => 'pegawai_id']);
    }

    /**
     * Gets query for [[Pendaftaran]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPendaftaran()
    {
        return $this->hasOne(DataPendaftaranPasien::class, ['id' => 'pendaftaran_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
