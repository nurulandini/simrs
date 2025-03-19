<?php

namespace app\console;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class ConfigController extends Controller
{
    public function actionTambahItem($tipe, $item, $description = NULL)
    {
        $type = NULL;

        if ($tipe == 'role') {
            $type = 1;
        } elseif ($tipe == 'item') {
            $type = 2;
        }

        $model = \app\models\AuthItem::findOne(['name' => $item, 'type' => $type]);

        if (!$model) {
            $model = new \app\models\AuthItem();
        }

        $model->name = $item;
        $model->type = $type;
        $model->description = $description;

        if ($model->save()) {
            var_dump($model->name . ' done');
        } else {
            var_dump($model->errors);
        }
    }

    public function actionTambahItemChild($parent, $child)
    {
        $model = \app\models\AuthItemChild::findOne(['parent' => $parent, 'child' => $child]);

        if (!$model) {
            $model = new \app\models\AuthItemChild();
        }

        $model->parent = $parent;
        $model->child = $child;

        if ($model->save()) {
            var_dump($model->parent . ' - ' . $model->child . ' done');
        } else {
            var_dump($model->errors);
        }
    }

    public function actionTambahUser($username, $password, $role, array $field = NULL)
    {
        $model = \app\models\User::findOne(['username' => $username]);

        if (!$model) {
            $model = new \app\models\User();
        }

        $model->username = $username;
        $model->email = $username . '@mail.com';
        $model->setPassword($password);
        $model->generateAuthKey();
        $model->created_at = time();
        $model->updated_at = time();

        if ($field) {
            foreach ($field as $key => $field) {
                $model->$key = $field;
            }
        }

        if ($model->save()) {
            Yii::$app->authManager->revokeAll($model->getId());
            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole($role);

            if ($auth->assign($authorRole, $model->getId())) {
                var_dump($model->username . ' done');
            }
        }
    }

    public function actionTambahAdmin($username, $password)
    {
        $this->actionTambahItem('role', 'admin_sistem', 'admin sistem');
        $this->actionTambahUser($username, $password, 'admin_sistem');
        $this->actionTambahItem('item', '/admin/*');
        $this->actionTambahItem('item', '/debug/*');
        $this->actionTambahItem('item', '/gii/*');
        $this->actionTambahItem('item', '/gridview/*');
        $this->actionTambahItem('item', '/user/*');
        $this->actionTambahItem('item', '/assignment/*');
        $this->actionTambahItem('item', '/role/*');
        $this->actionTambahItem('item', '/permission/*');
        $this->actionTambahItem('item', '/route/*');
        $this->actionTambahItem('item', '/rule/*');
        $this->actionTambahItem('item', '/menu/*');
        $this->actionTambahItemChild('admin_sistem', '/admin/*');
        $this->actionTambahItemChild('admin_sistem', '/debug/*');
        $this->actionTambahItemChild('admin_sistem', '/gii/*');
        $this->actionTambahItemChild('admin_sistem', '/gridview/*');
        $this->actionTambahItemChild('admin_sistem', '/user/*');
        $this->actionTambahItemChild('admin_sistem', '/assignment/*');
        $this->actionTambahItemChild('admin_sistem', '/role/*');
        $this->actionTambahItemChild('admin_sistem', '/permission/*');
        $this->actionTambahItemChild('admin_sistem', '/route/*');
        $this->actionTambahItemChild('admin_sistem', '/rule/*');
        $this->actionTambahItemChild('admin_sistem', '/menu/*');
    }

    public function actionTambahOperator($username, $password)
    {
        $this->actionTambahItem('role', 'operator', 'Operator');
        $this->actionTambahUser($username, $password, 'operator');
        $this->actionTambahItem('item', '/gridview/*');
        $this->actionTambahItem('item', '/user/profil');
        $this->actionTambahItem('item', '/user/change-profil');
        $this->actionTambahItem('item', '/user/change-password');
        $this->actionTambahItemChild('operator', '/gridview/*');
        $this->actionTambahItemChild('operator', '/user/profil');
        $this->actionTambahItemChild('operator', '/user/change-profil');
        $this->actionTambahItemChild('operator', '/user/change-password');
        $this->actionTambahItemChild('operator', '/data-tahun/*');
        $this->actionTambahItemChild('operator', '/data-sub-unit/*');
        $this->actionTambahItemChild('operator', '/data-satuan/*');
    }

    public function actionTambahMenu($nama_file)
    {
        $json = file_get_contents(Yii::getAlias('@app/console/file/' . $nama_file . '.json'));

        foreach (json_decode($json) as $index => $data) {
            $model = \app\models\Menu::findOne(['name' => $data->name]);

            if (!$model) {
                $model = new \app\models\Menu();
            }

            $model->id = $data->id;
            $model->name = $data->name;
            $model->parent = $data->parent;
            $model->route = $data->route;
            $model->order = $data->order;
            $model->data = $data->data;

            if ($model->save()) {
                var_dump($model->name . 'done');
            } else {
                var_dump($model->errors);
            }
        }
    }
}
