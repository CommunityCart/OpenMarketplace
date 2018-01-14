<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InvitesClaimed Controller
 *
 * @property \App\Model\Table\InvitesClaimedTable $InvitesClaimed
 *
 * @method \App\Model\Entity\InvitesClaimed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvitesClaimedController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Invites', 'Users', 'Vendors']
        ];
        $invitesClaimed = $this->paginate($this->InvitesClaimed);

        $this->set(compact('invitesClaimed'));
    }

    /**
     * View method
     *
     * @param string|null $id Invites Claimed id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invitesClaimed = $this->InvitesClaimed->get($id, [
            'contain' => ['Invites', 'Users', 'Vendors']
        ]);

        $this->set('invitesClaimed', $invitesClaimed);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invitesClaimed = $this->InvitesClaimed->newEntity();
        if ($this->request->is('post')) {
            $invitesClaimed = $this->InvitesClaimed->patchEntity($invitesClaimed, $this->request->getData());
            if ($this->InvitesClaimed->save($invitesClaimed)) {
                $this->Flash->success(__('The invites claimed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invites claimed could not be saved. Please, try again.'));
        }
        $invites = $this->InvitesClaimed->Invites->find('list', ['limit' => 200]);
        $users = $this->InvitesClaimed->Users->find('list', ['limit' => 200]);
        $vendors = $this->InvitesClaimed->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('invitesClaimed', 'invites', 'users', 'vendors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invites Claimed id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invitesClaimed = $this->InvitesClaimed->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invitesClaimed = $this->InvitesClaimed->patchEntity($invitesClaimed, $this->request->getData());
            if ($this->InvitesClaimed->save($invitesClaimed)) {
                $this->Flash->success(__('The invites claimed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invites claimed could not be saved. Please, try again.'));
        }
        $invites = $this->InvitesClaimed->Invites->find('list', ['limit' => 200]);
        $users = $this->InvitesClaimed->Users->find('list', ['limit' => 200]);
        $vendors = $this->InvitesClaimed->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('invitesClaimed', 'invites', 'users', 'vendors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invites Claimed id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invitesClaimed = $this->InvitesClaimed->get($id);
        if ($this->InvitesClaimed->delete($invitesClaimed)) {
            $this->Flash->success(__('The invites claimed has been deleted.'));
        } else {
            $this->Flash->error(__('The invites claimed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
