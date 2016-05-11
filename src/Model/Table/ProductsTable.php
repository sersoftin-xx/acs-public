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
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->addBehavior('Upload', [
                'fields' => [
                    'product_file' => [
                        'path' => 'upload/product/:product/:md5',
                    ]
                ],
                'overwrite' => true,
                'suffix' => '_upload'
            ]
        );
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
            ->add('name', 'length', ['rule' => ['lengthBetween', 3, 32], 'message' => __('Name of product must been more 3 and small 32 chars')]);

        $validator
            ->notEmpty('product_file')
            ->add('product_file', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('product_file', 'length', ['rule' => ['maxLength', 255], 'message' => __('Product file path must been small 255 chars')]);

        $validator
            ->notEmpty('download_name')
            ->add('download_name', 'validFormat', [
                'rule' => ['custom', '/^\w[\w\.]+$/i'],
                'message' => 'Please enter a valid download file name.'
            ])
            ->requirePresence('download_name', 'create')
            ->add('download_name', 'length', ['rule' => ['maxLength', 100], 'message' => __('Download file name must been small 100 chars')]);

        $validator
            ->add('version', 'valid', ['rule' => 'numeric'])
            ->requirePresence('version', 'create')
            ->notEmpty('version');

        $validator
            ->add('hidden', 'valid', ['rule' => 'boolean'])
            ->requirePresence('hidden', 'create')
            ->notEmpty('hidden');

        $validator
            ->requirePresence('addition_date', 'create')
            ->notEmpty('addition_date');

        $validator
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        $validator
            ->allowEmpty('description')
            ->add('description', 'length', ['rule' => ['maxLength', 255], 'message' => __('Description of product must been small 255 chars')]);

        return $validator;
    }
}
