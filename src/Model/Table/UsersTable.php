<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Groups
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
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
            ->allowEmpty('name')
            ->add('name', 'maxLength', [
                'rule' => [
                    'maxLength', 64
                ],
                'message' => 'Name max len 64 characters'
            ]);

        $validator
            ->requirePresence('login', 'create')
            ->add('login', 'length', [
                'rule' => [
                    'lengthBetween', 6, 16
                ],
                'message' => __('Login must be 6-16 chars.')
            ])
            ->notEmpty('login');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password')
            ->add('name', 'minLength', [
                'rule' => [
                    'minLength', 12
                ],
                'message' => 'The password must be longer than 12 characters.'
            ]);

        $validator
            ->dateTime('addition_date')
            ->allowEmpty('addition_date');

        $validator
            ->dateTime('edit_date')
            ->allowEmpty('edit_date');

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
        $rules->add($rules->isUnique(['login']));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        return $rules;
    }
}
