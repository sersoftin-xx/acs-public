<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\Table as Schema;

/**
 * Groups Model
 *
 * @property \Cake\ORM\Association\HasMany $Users
 */
class GroupsTable extends Table
{

    protected function _initializeSchema(Schema $schema)
    {
        $schema->columnType('permissions', 'array');
        return $schema;
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

        $this->table('groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'group_id',
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
            ->add('name', 'length', [
                'rule' => [
                    'lengthBetween', 4, 32
                ],
                'message' => 'Имя группы должно быть не менее 4-х и не более 32-х символов.'
            ]);

        $validator
            ->requirePresence('permissions', 'create')
            ->notEmpty('permissions');

        $validator
            ->dateTime('addition_date')
            ->allowEmpty('addition_date');

        $validator
            ->dateTime('edit_date')
            ->allowEmpty('edit_date');

        return $validator;
    }
}
