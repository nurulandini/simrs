<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "wilayah_kabupaten_kota".
 *
 * @property int $id
 * @property int $provinsi_id
 * @property int $kd_kabupaten_kota
 * @property string|null $kabupaten_kota
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property WilayahProvinsi $provinsi
 * @property User $updatedBy
 * @property WilayahKecamatan[] $wilayahKecamatans
 */
class WilayahKabupatenKota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wilayah_kabupaten_kota';
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
            [['provinsi_id', 'kd_kabupaten_kota'], 'required'],
            [['provinsi_id', 'kd_kabupaten_kota', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['kabupaten_kota'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['provinsi_id'], 'exist', 'skipOnError' => true, 'targetClass' => WilayahProvinsi::class, 'targetAttribute' => ['provinsi_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provinsi_id' => 'Provinsi ID',
            'kd_kabupaten_kota' => 'Kd Kabupaten Kota',
            'kabupaten_kota' => 'Kabupaten Kota',
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
     * Gets query for [[Provinsi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(WilayahProvinsi::class, ['id' => 'provinsi_id']);
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
     * Gets query for [[WilayahKecamatans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKecamatans()
    {
        return $this->hasMany(WilayahKecamatan::class, ['kabupaten_kota_id' => 'id']);
    }
}
