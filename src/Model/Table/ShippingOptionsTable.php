<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShippingOptions Model
 *
 * @property \App\Model\Table\VendorsTable|\Cake\ORM\Association\BelongsTo $Vendors
 *
 * @method \App\Model\Entity\ShippingOption get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShippingOption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShippingOption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShippingOption|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShippingOption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShippingOption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShippingOption findOrCreate($search, callable $callback = null, $options = [])
 */
class ShippingOptionsTable extends Table
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

        $this->setTable('shipping_options');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
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
            ->scalar('shipping_name')
            ->maxLength('shipping_name', 64)
            ->requirePresence('shipping_name', 'create')
            ->notEmpty('shipping_name');

        $validator
            ->scalar('shipping_carrier')
            ->maxLength('shipping_carrier', 64)
            ->requirePresence('shipping_carrier', 'create')
            ->notEmpty('shipping_carrier');

        $validator
            ->scalar('shipping_cost')
            ->maxLength('shipping_cost', 64)
            ->requirePresence('shipping_cost', 'create')
            ->notEmpty('shipping_cost');

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
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));

        return $rules;
    }
}
