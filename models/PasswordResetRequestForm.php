<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => 10],
                'message' => 'Email Anda Tidak Terdaftar.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::find()
            ->where(['status' => User::STATUS_ACTIVE])
            ->andWhere(['like', 'LOWER(email)', strtolower($this->email)])
            ->one();

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user, 'app_name' => Yii::$app->name]
            )
            ->setFrom([Yii::$app->params['adminEmail'] => 'Bappeda Kota Medan'])
            ->setTo($this->email)
            ->setSubject('Reset Password Aplikasi Sistem Informasi Manajemen Klinik')
            ->send();
    }
}
