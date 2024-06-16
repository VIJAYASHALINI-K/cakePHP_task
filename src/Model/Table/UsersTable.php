<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{
    
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsToMany('Products',[
            'joinTable' => 'ProductsUsers'
        ]);
    }
   
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->add('user_name', 'validUserName',[
                'rule' => 'isValidFname',
                'message' => __('username contains letters followed by whitespace follwed by letter'),
                'provider' => 'table',
                ])            
            ->requirePresence('user_name', 'create')
            ->notEmptyString('user_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->maxLength('password', 15)
            ->minLength('password', 8)
            ->notEmptyString('password');

        $validator
            ->scalar('address_line_1')
            ->requirePresence('address_line_1', 'create')
            ->maxLength('address_line_1', 35)
            ->minLength('address_line_1', 20)
            ->notEmptyString('address_line_1');

        $validator
            ->scalar('address_line_2')
            ->maxLength('address_line_2', 35)
            ->minLength('address_line_2', 0)
            ->allowEmpty('address_line_2', function ($context) {
                return !$context['data']['address_line_2'];
            });

        $validator
            ->numeric('pincode')
            ->requirePresence('pincode', 'create')
            ->maxLength('pincode',6)
            ->minLength('pincode',6)
            ->notEmptyString('pincode');
        $validator
            ->requirePresence('phone_number', 'create')
            ->numeric('phone_number')
            ->minLength('phone_number',10)
            ->maxLength('phone_number',10)
            ->notEmptyString('phone_number');
        
        return $validator;
    }

    public function isValidFname($value, array $context) {           
        if(preg_match("/^[A-Z]{1}[A-Za-z]{2,8}\s{1}[A-Z]{1,3}$/",$value)){
            return true;
        }
        else{
            return "username starts with uppercase letter followed by letters, whitespace and letter";
        }
    }
}
