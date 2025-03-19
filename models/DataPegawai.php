<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "data_pegawai".
 *
 * @property int $id
 * @property int $nip
 * @property string $nama
 * @property int $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $nomor_hp
 * @property string $alamat
 * @property int $kelurahan_id
 * @property int|null $poli_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataJadwalPegawai[] $dataJadwalPegawais
 * @property DataPendaftaranPasien[] $dataPendaftaranPasiens
 * @property DataSkrinning[] $dataSkrinnings
 * @property WilayahKelurahan $kelurahan
 * @property DataPoli $poli
 * @property User $updatedBy
 * @property User[] $users
 */
class DataPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_pegawai';
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
            [['nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nomor_hp', 'alamat', 'kelurahan_id'], 'required'],
            [['nip', 'jenis_kelamin', 'kelurahan_id', 'poli_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal_lahir'], 'safe'],
            [['alamat'], 'string'],
            [['nama', 'tempat_lahir'], 'string', 'max' => 100],
            [['nomor_hp'], 'string', 'max' => 20],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['kelurahan_id'], 'exist', 'skipOnError' => true, 'targetClass' => WilayahKelurahan::class, 'targetAttribute' => ['kelurahan_id' => 'id']],
            [['poli_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataPoli::class, 'targetAttribute' => ['poli_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nomor_hp' => 'Nomor Hp',
            'alamat' => 'Alamat',
            'kelurahan_id' => 'Kelurahan ID',
            'poli_id' => 'Poli ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
     * Gets query for [[DataJadwalPegawais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataJadwalPegawais()
    {
        return $this->hasMany(DataJadwalPegawai::class, ['pegawai_id' => 'id']);
    }

    /**
     * Gets query for [[DataPendaftaranPasiens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPendaftaranPasiens()
    {
        return $this->hasMany(DataPendaftaranPasien::class, ['pegawai_id' => 'id']);
    }

    /**
     * Gets query for [[DataSkrinnings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataSkrinnings()
    {
        return $this->hasMany(DataSkrinning::class, ['pegawai_id' => 'id']);
    }

    /**
     * Gets query for [[Kelurahan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKelurahan()
    {
        return $this->hasOne(WilayahKelurahan::class, ['id' => 'kelurahan_id']);
    }

    /**
     * Gets query for [[Poli]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoli()
    {
        return $this->hasOne(DataPoli::class, ['id' => 'poli_id']);
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
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['pegawai_id' => 'id']);
    }
}
