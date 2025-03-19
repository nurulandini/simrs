<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "data_pendaftaran_pasien".
 *
 * @property int $id
 * @property int $pasien_id
 * @property int $pegawai_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $tanggal_kunjungan
 *
 * @property User $createdBy
 * @property DataSkrinning[] $dataSkrinnings
 * @property DataPasien $pasien
 * @property DataPegawai $pegawai
 * @property User $updatedBy
 */

class DataPendaftaranPasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_pendaftaran_pasien';
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
            [['pasien_id', 'pegawai_id', 'tanggal_kunjungan'], 'required'],
            [['pasien_id', 'pegawai_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal_kunjungan'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['pasien_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataPasien::class, 'targetAttribute' => ['pasien_id' => 'id']],
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
            'pasien_id' => 'Pasien ID',
            'pegawai_id' => 'Pegawai ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'tanggal_kunjungan' => 'Tanggal Kunjungan',
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[DataSkrinnings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataSkrinnings()
    {
        return $this->hasMany(DataSkrinning::class, ['pendaftaran_id' => 'id']);
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
     * Gets query for [[Pasien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPasien()
    {
        return $this->hasOne(DataPasien::class, ['id' => 'pasien_id']);
    }
}
