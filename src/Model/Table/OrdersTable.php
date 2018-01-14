<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\WalletTransactionsTable|\Cake\ORM\Association\BelongsTo $WalletTransactions
 * @property \App\Model\Table\ShippingOptionsTable|\Cake\ORM\Association\BelongsTo $ShippingOptions
 * @property \App\Model\Table\DisputesTable|\Cake\ORM\Association\HasMany $Disputes
 * @property \App\Model\Table\ReviewsTable|\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WalletTransactions', [
            'foreignKey' => 'wallet_transaction_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ShippingOptions', [
            'foreignKey' => 'shipping_option_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Disputes', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'order_id'
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
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->scalar('shipping_details')
            ->allowEmpty('shipping_details');

        $validator
            ->dateTime('accepted')
            ->allowEmpty('accepted');

        $validator
            ->dateTime('shipped')
            ->allowEmpty('shipped');

        $validator
            ->dateTime('finalized')
            ->allowEmpty('finalized');

        $validator
            ->dateTime('rated')
            ->allowEmpty('rated');

        $validator
            ->integer('finalize_early')
            ->allowEmpty('finalize_early');

        $validator
            ->integer('paid_vendor')
            ->allowEmpty('paid_vendor');

        $validator
            ->integer('paid_commission_vendor')
            ->allowEmpty('paid_commission_vendor');

        $validator
            ->integer('paid_commission_user')
            ->allowEmpty('paid_commission_user');

        $validator
            ->scalar('paid_commission_admins')
            ->maxLength('paid_commission_admins', 512)
            ->allowEmpty('paid_commission_admins');

        $validator
            ->integer('paid_commission_superadmin')
            ->allowEmpty('paid_commission_superadmin');

        $validator
            ->numeric('order_total_dollars')
            ->allowEmpty('order_total_dollars');

        $validator
            ->scalar('order_total_crypto')
            ->maxLength('order_total_crypto', 255)
            ->allowEmpty('order_total_crypto');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['shipping_option_id'], 'ShippingOptions'));

        return $rules;
    }
}
