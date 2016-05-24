<?php
namespace App\Model\Table;

use App\Model\Entity\Pc;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pcs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
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
            'foreignKey' => 'pc_id',
            'dependent' => true
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'length', ['rule' => ['lengthBetween', 3, 15], 'message' => 'Имя компьютера должно быть не менее 3-х и не более 15-ти символов.']);

        $validator
            ->requirePresence('unique_key', 'create')
            ->notEmpty('unique_key')
            ->add('unique_key', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('unique_key', 'length', ['rule' => ['maxLength', 64], 'message' => 'Уникальный ключ не может быть больше 64-х символов.']);

        $validator
            ->dateTime('addition_date')
            ->requirePresence('addition_date', 'create')
            ->notEmpty('addition_date');

        $validator
            ->allowEmpty('comment')
            ->add('comment', 'length', ['rule' => ['maxLength', 150], 'message' => 'Комментарий компьютера не может быть больше 150 символов']);

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
        $rules->add($rules->isUnique(['unique_key']));
        //$rules->add($rules->existsIn(['client_id'], 'Clients'));
        return $rules;
    }
}
