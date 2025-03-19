<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "wilayah_kecamatan".
 *
 * @property int $id
 * @property int $kabupaten_kota_id
 * @property int $kd_kecamatan
 * @property string|null $kecamatan
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property WilayahKabupatenKota $kabupatenKota
 * @property User $updatedBy
 * @property WilayahKelurahan[] $wilayahKelurahans
 */
class WilayahKecamatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wilayah_kecamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kabupaten_kota_id', 'kd_kecamatan'], 'required'],
            [['kabupaten_kota_id', 'kd_kecamatan', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['kecamatan'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['kabupaten_kota_id'], 'exist', 'skipOnError' => true, 'targetClass' => WilayahKabupatenKota::class, 'targetAttribute' => ['kabupaten_kota_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kabupaten_kota_id' => 'Kabupaten Kota ID',
            'kd_kecamatan' => 'Kd Kecamatan',
            'kecamatan' => 'Kecamatan',
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
     * Gets query for [[KabupatenKota]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKabupatenKota()
    {
        return $this->hasOne(WilayahKabupatenKota::class, ['id' => 'kabupaten_kota_id']);
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
     * Gets query for [[WilayahKelurahans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKelurahans()
    {
        return $this->hasMany(WilayahKelurahan::class, ['kecamatan_id' => 'id']);
    }
}
