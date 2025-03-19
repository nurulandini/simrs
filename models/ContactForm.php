<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Kontak;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }

    public function send()
    {
        if (!$this->validate()) {
            return null;
        }

        $kontak = new Kontak();
        $kontak->nama = $this->name;
        $kontak->email = $this->name;

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
