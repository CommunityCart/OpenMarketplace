<?php

namespace App\Model\Table;

use CakeDC\Users\Model\Table\UsersTable as BaseUsersTable;

/**
 * Users Model
 */
class UsersTable extends BaseUsersTable
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->hasMany('users_subscriptions', ['className' => 'UsersSubscriptions'])->setForeignKey('user_id')->setProperty('user');
        $this->hasMany('orders', ['className' => 'Orders'])->setForeignKey('user_id')->setProperty('orders');

        $this->removeBehavior('Register');
        $this->addBehavior('Register');
    }
}