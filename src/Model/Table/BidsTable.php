<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bids Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\BelongsTo $Pcs
 */
class BidsTable extends Table
{

    public function blockBidsForPc($pc_id = null)
    {
        return $this->updateAll([
            'is_active' => false
        ], [
            'pc_id' => $pc_id,
            'is_active' => true
        ]);
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('bids');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pcs', [
            'foreignKey' => 'pc_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('application_date', 'create')
            ->dateTime('application_date')
            ->notEmpty('application_date');

        $validator
            ->add('is_active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

        $validator
            ->dateTime('activation_date');

        $validator
            ->dateTime('expiration_date');

        return $validator;
    }

    public function findActive(Query $query, array $options)
    {
        return $query->where(['is_active' => true]);
    }

    public function findRecent(Query $query, array $options)
    {
        return $query->where(['is_active' => false]);
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
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['pc_id'], 'Pcs'));
        return $rules;
    }
}
