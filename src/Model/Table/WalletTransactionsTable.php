<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WalletTransactions Model
 *
 * @property \App\Model\Table\WalletsTable|\Cake\ORM\Association\BelongsTo $Wallets
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\UserTransactionsTable|\Cake\ORM\Association\HasMany $UserTransactions
 *
 * @method \App\Model\Entity\WalletTransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\WalletTransaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WalletTransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WalletTransaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WalletTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WalletTransaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WalletTransaction findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WalletTransactionsTable extends Table
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

        $this->setTable('wallet_transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Wallets', [
            'foreignKey' => 'wallet_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'wallet_transaction_id'
        ]);
        $this->hasMany('UserTransactions', [
            'foreignKey' => 'wallet_transaction_id'
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
            ->scalar('transaction_hash')
            ->maxLength('transaction_hash', 255)
            ->requirePresence('transaction_hash', 'create')
            ->notEmpty('transaction_hash');

        $validator
            ->scalar('transaction_details')
            ->requirePresence('transaction_details', 'create')
            ->notEmpty('transaction_details');

        $validator
            ->numeric('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');

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
        $rules->add($rules->existsIn(['wallet_id'], 'Wallets'));

        return $rules;
    }
}
