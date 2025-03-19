<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_jadwal_pegawai".
 *
 * @property int $id
 * @property int $pegawai_id
 * @property int $hari_kerja
 * @property int $shift
 * @property string $mulai
 * @property string $akhir
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property DataPegawai $pegawai
 * @property User $updatedBy
 */
class DataJadwalPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_jadwal_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pegawai_id', 'hari_kerja', 'shift', 'mulai', 'akhir'], 'required'],
            [['pegawai_id', 'hari_kerja', 'shift', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['mulai', 'akhir'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
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
            'pegawai_id' => 'Pegawai ID',
            'hari_kerja' => 'Hari Kerja',
            'shift' => 'Shift',
            'mulai' => 'Mulai',
            'akhir' => 'Akhir',
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
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(DataPegawai::class, ['id' => 'pegawai_id']);
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
