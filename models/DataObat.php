<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "data_obat".
 *
 * @property int $id
 * @property string $nama
 * @property int $kategori_id
 * @property string $deskripsi
 * @property string $tanggal_kedaluwarsa
 * @property int|null $persediaan
 * @property int|null $satuan_id
 * @property int $harga_per_unit
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataResepDetail[] $dataResepDetails
 * @property KategoriObat $kategori
 * @property DataSatuan $satuan
 * @property User $updatedBy
 */
class DataObat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_obat';
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
            [['nama', 'kategori_id', 'deskripsi', 'tanggal_kedaluwarsa', 'harga_per_unit'], 'required'],
            [['kategori_id', 'persediaan', 'satuan_id', 'harga_per_unit', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['deskripsi'], 'string'],
            [['tanggal_kedaluwarsa'], 'safe'],
            [['nama'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriObat::class, 'targetAttribute' => ['kategori_id' => 'id']],
            [['satuan_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataSatuan::class, 'targetAttribute' => ['satuan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'kategori_id' => 'Kategori ID',
            'deskripsi' => 'Deskripsi',
            'tanggal_kedaluwarsa' => 'Tanggal Kedaluwarsa',
            'persediaan' => 'Persediaan',
            'satuan_id' => 'Satuan ID',
            'harga_per_unit' => 'Harga Per Unit',
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
     * Gets query for [[DataResepDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataResepDetails()
    {
        return $this->hasMany(DataResepDetail::class, ['obat_id' => 'id']);
    }

    /**
     * Gets query for [[Kategori]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(KategoriObat::class, ['id' => 'kategori_id']);
    }

    /**
     * Gets query for [[Satuan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(DataSatuan::class, ['id' => 'satuan_id']);
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
