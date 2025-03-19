<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * Description of ChangePassword
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ChangePassword extends Model
{
    //    public $oldPassword;
    public $newPassword;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newPassword', 'retypePassword'], 'required'],
            [['newPassword'], 'string', 'min' => 6],
            [['retypePassword'], 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => 'Password Baru',
            'retypePassword' => 'Ketik Ulang Password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', 'Incorrect old password.');
        }
    }

    /**
     * Change password.
     *
     * @return User|null the saved model or null if saving fails
     */

    public function change($user)
    {
        if ($this->validate()) {
            $user->setPassword($this->newPassword);
            $user->generateAuthKey();
            return $user->save(false);
        }
        return false;
    }
}
