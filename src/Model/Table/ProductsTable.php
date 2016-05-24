<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\HasMany $Bids
 */
class ProductsTable extends Table
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

        $this->table('products');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Bids', [
            'foreignKey' => 'product_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('name', 'length', ['rule' => ['lengthBetween', 3, 32], 'message' => 'Имя продукта не может быть мнеьше 3-х и больше 32-х символов.']);

        $validator
            ->requirePresence('addition_date', 'create')
            ->notEmpty('addition_date');

        $validator
            ->allowEmpty('description')
            ->add('description', 'length', ['rule' => ['maxLength', 255], 'message' => 'Описание продукта должно быть меньше 255 символов.']);

        return $validator;
    }
}
