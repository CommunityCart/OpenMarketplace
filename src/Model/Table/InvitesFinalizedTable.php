<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvitesFinalized Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property |\Cake\ORM\Association\BelongsTo $Invites
 *
 * @method \App\Model\Entity\InvitesFinalized get($primaryKey, $options = [])
 * @method \App\Model\Entity\InvitesFinalized newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InvitesFinalized[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvitesFinalized|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvitesFinalized patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InvitesFinalized[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvitesFinalized findOrCreate($search, callable $callback = null, $options = [])
 */
class InvitesFinalizedTable extends Table
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

        $this->setTable('invites_finalized');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invites', [
            'foreignKey' => 'invite_id',
            'joinType' => 'INNER'
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
            ->numeric('commission')
            ->requirePresence('commission', 'create')
            ->notEmpty('commission');

        $validator
            ->dateTime('finalized')
            ->requirePresence('finalized', 'create')
            ->notEmpty('finalized');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['invite_id'], 'Invites'));

        return $rules;
    }
}
