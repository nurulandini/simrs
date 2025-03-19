<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use Yii;

/**
 * This is the model class for table "rekam_medis_detail".
 *
 * @property int $id
 * @property int|null $rekam_medis_id
 * @property int|null $layanan_id
 * @property int|null $biaya
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property LayananMedis $layanan
 * @property DataRekamMedis $rekamMedis
 * @property User $updatedBy
 */
class RekamMedisDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rekam_medis_detail';
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
            [['rekam_medis_id', 'layanan_id', 'biaya', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['layanan_id'], 'exist', 'skipOnError' => true, 'targetClass' => LayananMedis::class, 'targetAttribute' => ['layanan_id' => 'id']],
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
            'layanan_id' => 'Layanan ID',
            'biaya' => 'Biaya',
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
     * Gets query for [[Layanan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLayanan()
    {
        return $this->hasOne(LayananMedis::class, ['id' => 'layanan_id']);
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
