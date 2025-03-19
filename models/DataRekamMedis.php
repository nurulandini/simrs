<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use Yii;

/**
 * This is the model class for table "data_rekam_medis".
 *
 * @property int $id
 * @property int $skrinning_id
 * @property string $diagnosa
 * @property string|null $catatan
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataResepDetail[] $dataResepDetails
 * @property DataRujukan[] $dataRujukans
 * @property RekamMedisDetail[] $rekamMedisDetails
 * @property DataSkrinning $skrinning
 * @property Transaksi[] $transaksis
 * @property User $updatedBy
 */
class DataRekamMedis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_rekam_medis';
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
            [['skrinning_id', 'diagnosa'], 'required'],
            [['skrinning_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['diagnosa', 'catatan'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['skrinning_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataSkrinning::class, 'targetAttribute' => ['skrinning_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'skrinning_id' => 'Skrinning ID',
            'diagnosa' => 'Diagnosa',
            'catatan' => 'Catatan',
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
        return $this->hasMany(DataResepDetail::class, ['rekam_medis_id' => 'id']);
    }

    /**
     * Gets query for [[DataRujukans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataRujukans()
    {
        return $this->hasMany(DataRujukan::class, ['rekam_medis_id' => 'id']);
    }

    /**
     * Gets query for [[RekamMedisDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRekamMedisDetails()
    {
        return $this->hasMany(RekamMedisDetail::class, ['rekam_medis_id' => 'id']);
    }

    /**
     * Gets query for [[Skrinning]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkrinning()
    {
        return $this->hasOne(DataSkrinning::class, ['id' => 'skrinning_id']);
    }

    /**
     * Gets query for [[Transaksis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::class, ['rekam_medis_id' => 'id']);
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
