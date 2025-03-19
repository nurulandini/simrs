<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\User;

/**
 * Password reset form
 */
class ChangePasswordProfil extends Model
{

    public $currentPassword;
    public $newPassword;
    public $newPasswordConfirm;

    /**
     * @var \app\models\User
     */
    private $_user;

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordConfirm'], 'required'],
            [['currentPassword', 'newPassword', 'newPasswordConfirm'], 'string'],
            [['currentPassword'], 'validatePassword'],
            [['newPasswordConfirm'], 'validateMyCompare']
        ];
    }
    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Password Lama',
            'newPassword' => 'Password Baru',
            'newPasswordConfirm' => 'Konfirmasi Password Baru',
        ];
    }

    public function resetPassword()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setPassword($this->newPassword);
            return $user->save(false);
        }
        return false;
    }

    public function validateMyCompare($attribute, $params)
    {
        if ($this->newPassword !== $this->newPasswordConfirm) {
            $this->addError($attribute, 'Password konfirmasi tidak cocok dengan password baru anda');
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, 'Password salah.');
            }
        }
    }

    protected function getUser()
    {
        $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        return $this->_user;
    }
}
