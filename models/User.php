<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $pegawai_id
 *
 * @property DataJadwalPegawai[] $dataJadwalPegawais
 * @property DataJadwalPegawai[] $dataJadwalPegawais0
 * @property DataObat[] $dataObats
 * @property DataObat[] $dataObats0
 * @property DataPasien[] $dataPasiens
 * @property DataPasien[] $dataPasiens0
 * @property DataPegawai[] $dataPegawais
 * @property DataPegawai[] $dataPegawais0
 * @property DataPendaftaranPasien[] $dataPendaftaranPasiens
 * @property DataPendaftaranPasien[] $dataPendaftaranPasiens0
 * @property DataPoli[] $dataPolis
 * @property DataPoli[] $dataPolis0
 * @property DataRekamMedis[] $dataRekamMedis
 * @property DataRekamMedis[] $dataRekamMedis0
 * @property DataResepDetail[] $dataResepDetails
 * @property DataResepDetail[] $dataResepDetails0
 * @property DataRujukan[] $dataRujukans
 * @property DataRujukan[] $dataRujukans0
 * @property DataSatuan[] $dataSatuans
 * @property DataSatuan[] $dataSatuans0
 * @property DataSkrinning[] $dataSkrinnings
 * @property DataSkrinning[] $dataSkrinnings0
 * @property KategoriObat[] $kategoriObats
 * @property KategoriObat[] $kategoriObats0
 * @property LayananMedis[] $layananMedis
 * @property LayananMedis[] $layananMedis0
 * @property DataPegawai $pegawai
 * @property RekamMedisDetail[] $rekamMedisDetails
 * @property RekamMedisDetail[] $rekamMedisDetails0
 * @property Transaksi[] $transaksis
 * @property Transaksi[] $transaksis0
 * @property WilayahKabupatenKota[] $wilayahKabupatenKotas
 * @property WilayahKabupatenKota[] $wilayahKabupatenKotas0
 * @property WilayahKecamatan[] $wilayahKecamatans
 * @property WilayahKecamatan[] $wilayahKecamatans0
 * @property WilayahKelurahan[] $wilayahKelurahans
 * @property WilayahKelurahan[] $wilayahKelurahans0
 * @property WilayahProvinsi[] $wilayahProvinsis
 * @property WilayahProvinsi[] $wilayahProvinsis0
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            // BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['created_at', 'updated_at','pegawai_id'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
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
            'username' => 'Username',
            'pegawai_id' => 'Nama Pegawai',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }

   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Gets query for [[DataJadwalPegawais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataJadwalPegawais()
    {
        return $this->hasMany(DataJadwalPegawai::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataJadwalPegawais0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataJadwalPegawais0()
    {
        return $this->hasMany(DataJadwalPegawai::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataObats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataObats()
    {
        return $this->hasMany(DataObat::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataObats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataObats0()
    {
        return $this->hasMany(DataObat::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataPasiens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPasiens()
    {
        return $this->hasMany(DataPasien::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataPasiens0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPasiens0()
    {
        return $this->hasMany(DataPasien::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataPegawais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPegawais()
    {
        return $this->hasMany(DataPegawai::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataPegawais0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPegawais0()
    {
        return $this->hasMany(DataPegawai::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataPendaftaranPasiens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPendaftaranPasiens()
    {
        return $this->hasMany(DataPendaftaranPasien::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataPendaftaranPasiens0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPendaftaranPasiens0()
    {
        return $this->hasMany(DataPendaftaranPasien::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataPolis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPolis()
    {
        return $this->hasMany(DataPoli::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataPolis0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataPolis0()
    {
        return $this->hasMany(DataPoli::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataRekamMedis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataRekamMedis()
    {
        return $this->hasMany(DataRekamMedis::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataRekamMedis0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataRekamMedis0()
    {
        return $this->hasMany(DataRekamMedis::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataResepDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataResepDetails()
    {
        return $this->hasMany(DataResepDetail::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataResepDetails0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataResepDetails0()
    {
        return $this->hasMany(DataResepDetail::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataRujukans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataRujukans()
    {
        return $this->hasMany(DataRujukan::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataRujukans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataRujukans0()
    {
        return $this->hasMany(DataRujukan::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataSatuans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataSatuans()
    {
        return $this->hasMany(DataSatuan::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataSatuans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataSatuans0()
    {
        return $this->hasMany(DataSatuan::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[DataSkrinnings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataSkrinnings()
    {
        return $this->hasMany(DataSkrinning::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DataSkrinnings0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataSkrinnings0()
    {
        return $this->hasMany(DataSkrinning::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[KategoriObats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriObats()
    {
        return $this->hasMany(KategoriObat::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[KategoriObats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriObats0()
    {
        return $this->hasMany(KategoriObat::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[LayananMedis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLayananMedis()
    {
        return $this->hasMany(LayananMedis::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[LayananMedis0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLayananMedis0()
    {
        return $this->hasMany(LayananMedis::class, ['updated_by' => 'id']);
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
     * Gets query for [[RekamMedisDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRekamMedisDetails()
    {
        return $this->hasMany(RekamMedisDetail::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[RekamMedisDetails0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRekamMedisDetails0()
    {
        return $this->hasMany(RekamMedisDetail::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Transaksis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Transaksis0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis0()
    {
        return $this->hasMany(Transaksi::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahKabupatenKotas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKabupatenKotas()
    {
        return $this->hasMany(WilayahKabupatenKota::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahKabupatenKotas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKabupatenKotas0()
    {
        return $this->hasMany(WilayahKabupatenKota::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahKecamatans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKecamatans()
    {
        return $this->hasMany(WilayahKecamatan::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahKecamatans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKecamatans0()
    {
        return $this->hasMany(WilayahKecamatan::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahKelurahans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKelurahans()
    {
        return $this->hasMany(WilayahKelurahan::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahKelurahans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahKelurahans0()
    {
        return $this->hasMany(WilayahKelurahan::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahProvinsis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahProvinsis()
    {
        return $this->hasMany(WilayahProvinsi::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WilayahProvinsis0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahProvinsis0()
    {
        return $this->hasMany(WilayahProvinsi::class, ['updated_by' => 'id']);
    }

    
}
