<?php

namespace app\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\User;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \app\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            Yii::error('Token kosong atau tidak valid');
            throw new InvalidParamException('Password reset token cannot be blank.');
        }

        Yii::info('Mencari user dengan token: ' . $token);  // Menambahkan log untuk token yang diterima
        $this->_user = User::findByPasswordResetToken($token);

        if (!$this->_user) {
            Yii::error('User tidak ditemukan dengan token: ' . $token);
            throw new InvalidParamException('Wrong password reset token.');
        }

        Yii::info('User ditemukan: ' . $this->_user->email);  // Log user yang ditemukan
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        Yii::info('Memulai proses reset password untuk user: ' . $this->_user->email);

        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        // Simpan perubahan ke database
        if ($user->save(false)) {
            Yii::info('Password berhasil direset untuk user: ' . $this->_user->email);
            return true;
        } else {
            Yii::error('Gagal menyimpan user setelah reset password: ' . json_encode($user->errors));
            return false;
        }
    }
}
