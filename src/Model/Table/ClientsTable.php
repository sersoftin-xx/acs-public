<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clients Model
 *
 * @property \Cake\ORM\Association\HasMany $Pcs
 */
class ClientsTable extends Table
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

        $this->table('clients');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Pcs', [
            'foreignKey' => 'client_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->add('name', 'length', ['rule' => ['lengthBetween', 3, 32], 'message' => 'Имя клиента должно быть не менее 3-х и не более 32-х символов.']);

        $validator
            ->requirePresence('contact', 'create')
            ->notEmpty('contact')
            ->add('contact', 'valid-url', ['rule' => 'url', 'message' => 'Введите валидный контакт клиента'])
            ->add('contact', 'length', ['rule' => ['lengthBetween', 3, 32], 'message' => 'Контакт клиента должен быть не менее 3-х и не более 32-х символов.']);

        $validator
            ->requirePresence('addition_date', 'create')
            ->notEmpty('addition_date');

        $validator
            ->allowEmpty('note')
            ->add('note', 'length', ['rule' => ['maxLength', 150, 'message' => 'Примечание клиента не может быть больше 150 символов.']]);

        return $validator;
    }
}
