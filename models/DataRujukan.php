<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_rujukan".
 *
 * @property int $id
 * @property int|null $rekam_medis_id
 * @property string|null $rumah_sakit
 * @property string|null $catatan
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataRekamMedis $rekamMedis
 * @property User $updatedBy
 */
class DataRujukan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_rujukan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rekam_medis_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['rumah_sakit', 'catatan'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
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
            'rumah_sakit' => 'Rumah Sakit',
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
