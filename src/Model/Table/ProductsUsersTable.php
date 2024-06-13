<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsUsers Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductsUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductsUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductsUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductsUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductsUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductsUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductsUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductsUser findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductsUsersTable extends Table
{
   
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users');
        $this->belongsTo('Products');
    }

   
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }

    
}
