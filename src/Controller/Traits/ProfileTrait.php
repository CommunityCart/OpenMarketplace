<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace App\Controller\Traits;

use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Covers the profile action
 *
 * @property \Cake\Http\ServerRequest $request
 */
trait ProfileTrait
{

    /**
     * Profile action
     * @param mixed $id Profile id object.
     * @return mixed
     */
    public function profile($id = null)
    {
        $loggedUserId = $this->Auth->user('id');
        $isCurrentUser = false;
        $validatePassword = true;

        if (!Configure::read('Users.Profile.viewOthers') || empty($id)) {

            $id = $loggedUserId;
        }

        try {

            $appContain = (array)Configure::read('Auth.authenticate.' . AuthComponent::ALL . '.contain');

            $socialContain = Configure::read('Users.Social.login') ? ['SocialAccounts']: [];

            $user = $this->getUsersTable()->get($id,
                [
                    'contain' => array_merge((array)$appContain, (array)$socialContain)
                ]
            );

            if ($user->id === $loggedUserId) {

                $isCurrentUser = true;
            }
        }
        catch (RecordNotFoundException $ex) {

            $this->Flash->error(__d('CakeDC/Users', 'User was not found'));

            return $this->redirect($this->request->referer());
        }
        catch (InvalidPrimaryKeyException $ex) {

            $this->Flash->error(__d('CakeDC/Users', 'Not authorized, please login first'));

            return $this->redirect($this->request->referer());
        }

        $userPasswordEntity = $this->getUsersTable()->newEntity();
        $userPasswordEntity->id = $this->Auth->user('id');

        $table = $this->loadModel();
        $tableAlias = $table->alias();

        $entity = $table->get($id,
            [
                'contain' => []
            ]
        );

        $this->set('avatarPlaceholder', Configure::read('Users.Avatar.placeholder'));
        $this->set('validatePassword', $validatePassword);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->set(compact('user', 'isCurrentUser', 'userPasswordEntity'));
        $this->set('_serialize', ['user', 'isCurrentUser', 'userPasswordEntity', $tableAlias, 'tableAlias']);

        $this->render('profile');
    }
}
