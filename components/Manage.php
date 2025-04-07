<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Manage extends Component
{
    /* function roleCheck
     ** $role = role user yang ingin diperiksa (string|array)
     ** $id = user id yang ingin diperiksa (string)
     ** return boolean;
    */
    public function roleCheck($role, $id = NULL)
    {
        if (!$id) $id = Yii::$app->user->getId();
        $roles = Yii::$app->authManager->getRolesByUser($id);
        $roles = array_keys($roles);

        if (is_array($roles)) {
            if (is_array($role)) {
                if (count(array_intersect($role, $roles))) {
                    return true;
                }
            } else {
                if (in_array($role, $roles)) {
                    return true;
                }
            }
        }

        return false;
    }

    /* function roleDetail
     ** $role = role user yang ingin diperiksa (string)
     ** $id = user id yang ingin diperiksa (string)
     ** return (data|NULL);
    */
}
