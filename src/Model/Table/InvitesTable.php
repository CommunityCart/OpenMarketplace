<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invites Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\InvitesClaimedTable|\Cake\ORM\Association\HasMany $InvitesClaimed
 * @property |\Cake\ORM\Association\HasMany $InvitesFinalized
 *
 * @method \App\Model\Entity\Invite get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invite findOrCreate($search, callable $callback = null, $options = [])
 */
class InvitesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('invites');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('InvitesClaimed', [
            'foreignKey' => 'invite_id'
        ]);
        $this->hasMany('InvitesFinalized', [
            'foreignKey' => 'invite_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('code')
            ->maxLength('code', 64)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        $validator
            ->integer('count_left')
            ->requirePresence('count_left', 'create')
            ->notEmpty('count_left');

        $validator
            ->integer('count_claimed')
            ->requirePresence('count_claimed', 'create')
            ->notEmpty('count_claimed');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
