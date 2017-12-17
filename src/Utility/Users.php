<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:35 AM
 */

namespace App\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class Users
{
    public function getUserTable()
    {
        $usersTable = TableRegistry::get(Configure::read('Users.table'));

        return $usersTable;
    }

    public function update($user, $column, $value)
    {
        $usersTable = $this->getUserTable();
        $user->set($column, $value);
        $usersTable->save($user);
    }

    public function getUserById($id)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }

    public function getUserByEmail($email)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.email' => $email])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }

    public function getUserRoleById($id)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity->get('role');
    }

    public function findUserBySubscriptionId($id)
    {
        $subscriptionsTable = TableRegistry::get('users_subscriptions');
        $subscriptionQuery = $subscriptionsTable->find('all')->where(['subscription_id' => $id])->limit(1);
        $subscriptionEntity = $subscriptionQuery->first();

        $usersTable = $this->getUserTable();

        if(isset($subscriptionEntity)) {

            $userQuery = $usersTable->find('all')
                ->where(['id' => $subscriptionEntity->get('user_id')]);

            $userEntity = $userQuery->first();

            return $userEntity;
        }
        else {

            return null;
        }
    }

    public function findSubscriptionIdByUserId($id)
    {
        $usersTable = $this->getUserTable();

        $subscriptionsTable = TableRegistry::get('users_subscriptions');
        $subscriptionQuery = $subscriptionsTable->find('all')->where(['user_id' => $id])->orderDesc('ref_id')->limit(1);
        $subscriptionEntity = $subscriptionQuery->first();

        return $subscriptionEntity->get('subscription_id');
    }

    public function findAllUsersBy($column, $value)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.' . $column => $value]);
        $usersEntities = $usersQuery->all();

        return $usersEntities;
    }

    public function countAllUsersBy($column, $value)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.' . $column => $value]);
        $usersEntities = $usersQuery->count();

        return $usersEntities;
    }

    public function getUserObject($id)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }
}