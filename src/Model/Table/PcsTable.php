<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pcs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Bids
 */
class PcsTable extends Table
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

        $this->table('pcs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('Bids', [
            'dependent' => true,
            'cascadeCallbacks' => true,
            'foreignKey' => 'pc_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'length', ['rule' => ['lengthBetween', 3, 15], 'message' => __('PC name len must be between 3 and 15 chars.')]);

        $validator
            ->requirePresence('unique_key', 'create')
            ->notEmpty('unique_key')
            ->add('unique_key', 'length', ['rule' => ['maxLength', 256], 'message' => __('PC unique key len must been small 256 chars.')]);

        $validator
            ->requirePresence('addition_date', 'create')
            ->notEmpty('addition_date');

        $validator
            ->allowEmpty('comment')
            ->add('comment', 'length', ['rule' => ['maxLength', 150], 'message' => __('PC comment max len = 150 chars.')]);

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        return $rules;
    }
}
