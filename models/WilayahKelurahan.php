<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wilayah_kelurahan".
 *
 * @property int $id
 * @property int $kecamatan_id
 * @property int $kd_kelurahan
 * @property string $kelurahan
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataPasien[] $dataPasiens
 * @property DataPegawai[] $dataPegawais
 * @property WilayahKecamatan $kecamatan
 * @property User $updatedBy
 */
class WilayahKelurahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wilayah_kelurahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kecamatan_id', 'kd_kelurahan', 'kelurahan'], 'required'],
            [['kecamatan_id', 'kd_kelurahan', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['kelurahan'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['kecamatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => WilayahKecamatan::class, 'targetAttribute' => ['kecamatan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kecamatan_id' => 'Kecamatan ID',
            'kd_kelurahan' => 'Kd Kelurahan',
            'kelurahan' => 'Kelurahan',
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
     * Gets query for [[DataPasiens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPasiens()
    {
        return $this->hasMany(DataPasien::class, ['kelurahan_id' => 'id']);
    }

    /**
     * Gets query for [[DataPegawais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPegawais()
    {
        return $this->hasMany(DataPegawai::class, ['kelurahan_id' => 'id']);
    }

    /**
     * Gets query for [[Kecamatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKecamatan()
    {
        return $this->hasOne(WilayahKecamatan::class, ['id' => 'kecamatan_id']);
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
