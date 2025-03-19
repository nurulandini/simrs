<?php

namespace app\controllers;

use app\components\ItemController;
use yii\rbac\Item;

/**
 * RoleController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class RoleController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'Item' => 'Role',
            'Items' => 'Roles',
        ];
    }
    
    public function actions()
    {
        $this->layout = 'theme/main';
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_ROLE;
    }
}
