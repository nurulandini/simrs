<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "data_resep_detail".
 *
 * @property int $id
 * @property int|null $rekam_medis_id
 * @property int|null $obat_id
 * @property string|null $dosis
 * @property int|null $jumlah
 * @property int|null $biaya
 * @property string|null $instruksi
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataObat $obat
 * @property DataRekamMedis $rekamMedis
 * @property User $updatedBy
 */
class DataResepDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_resep_detail';
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
            [['rekam_medis_id', 'obat_id', 'jumlah', 'biaya', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['instruksi'], 'string'],
            [['dosis'], 'string', 'max' => 50],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataObat::class, 'targetAttribute' => ['obat_id' => 'id']],
            [['rekam_medis_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataRekamMedis::class, 'targetAttribute' => ['rekam_medis_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rekam_medis_id' => 'Rekam Medis ID',
            'obat_id' => 'Obat ID',
            'dosis' => 'Dosis',
            'jumlah' => 'Jumlah',
            'biaya' => 'Biaya',
            'instruksi' => 'Instruksi',
            'status' => 'Status',
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
     * Gets query for [[Obat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(DataObat::class, ['id' => 'obat_id']);
    }

    /**
     * Gets query for [[RekamMedis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRekamMedis()
    {
        return $this->hasOne(DataRekamMedis::class, ['id' => 'rekam_medis_id']);
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
