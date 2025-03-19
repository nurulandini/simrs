<?php

namespace app\models;

use yii\base\Model;
use app\models\User;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;



class SignupUser extends Model
{
    public $username;
    public $auth_key;
    public $password_hash;
    public $email;
    public $created_at;
    public $updated_at;
    public $perusahaan_id;
    public $lsm_id;
    public $masyarakat_id;
    public $subunit_id;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password_hash', 'username'], 'required'],
            [['email'], 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Username sudah ada yang punya.'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Email sudah ada yang punya.'],
            ['email', 'string', 'max' => 100],
            ['password_hash', 'string', 'min' => 6],
            [['created_at', 'updated_at', 'perusahaan_id', 'lsm_id', 'masyarakat_id', 'subunit_id'], 'integer'],
            ['verifyCode', 'captcha'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'perusahaan_id' => 'Perusahaan',
            'lsm_id' => 'Lsm',
            'masyarakat_id' => 'UMKM',
            'subunit_id' => 'Perangkat Daerah',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = HtmlPurifier::process($this->username);
        $user->email = $this->email;
        $user->status = 0;
        $user->created_at = time();
        $user->updated_at = time();
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();
        $user->perusahaan_id = $this->perusahaan_id;
        $user->lsm_id = $this->lsm_id;
        $user->masyarakat_id = $this->masyarakat_id;

        if (
            // false
            $user->save()
        ) {
            if ($user->perusahaan_id != 0) {
                $auth = \Yii::$app->authManager;
                $authorRole = $auth->getRole("Perusahaan");
                $auth->assign($authorRole, $user->getId());
                return $user;
            } elseif ($user->lsm_id != 0) {
                $auth = \Yii::$app->authManager;
                $authorRole = $auth->getRole("Lsm");
                $auth->assign($authorRole, $user->getId());
                return $user;
            } elseif ($user->masyarakat_id != 0) {
                $auth = \Yii::$app->authManager;
                $authorRole = $auth->getRole("Umkm");
                $auth->assign($authorRole, $user->getId());
                return $user;
            }
        }

        return null;
    }
}
