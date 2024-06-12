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
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        // $this->hasMany('Products');
        $this->belongsToMany('Products',[
            'joinTable' => 'ProductsUsers',
            // 'through' => 'ProductsUsers'
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
            ->allowEmptyString('id', null, 'create');

        $validator
            // ->alphanumeric('fname')
            ->add('fname', 'validFname',[
                'rule' => 'isValidFname',
                'message' => __('Fname contains only letters'),
                'provider' => 'table',
                ])
            
            ->requirePresence('fname', 'create')
            // ->maxLength('fname', 15)
            // ->minLength('fname', 3)
            ->notEmptyString('fname');
            // ,'fname contains only letters',function ($context){
            //     return ($context['data']['fname']);
            // });

        $validator
            // ->ascii('lname')
            ->requirePresence('lname', 'create')
            ->add('lname', 'validLname',[
                'rule' => 'isValidLname',
                'message' => __('Lname contains only letters'),
                'provider' => 'table',
                ])
            // ->maxLength('lname', 3)
            // ->minLength('lname', 1)
            ->notEmptyString('lname');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    // public function buildRules(RulesChecker $rules)
    // {
    //     $rules->add($rules->isUnique(['email']));

    //     return $rules;
    // }
    public function isValidFname($value, array $context) {            
       
        if(preg_match("/^[A-Z]{3,8}$/",$value)){
            // Log::debug("if valid");
            return true;
        }
        else{
            // Log::debug("else valid");
            return "Fname contains only letters";
        }
        // Log::debug($value);
        // $result=preg_match("/^[A-Z]{3,8}$/",$value);
        // Log::debug("FNMAE");
        // Log::debug($result);
        // return $result;
        // return preg_match("/^[A-Z]{3,8}$/",$value);
    }
    public function isValidLname($value, array $context) {            
       
        if(preg_match("/^[A-Z]{1,3}$/",$value)){
            // Log::debug("if valid");
            // return false;
            return true;
        }
        else{
            // Log::debug("else valid");
            return "Lname contains only letters";
            // return "valid";
        }
        // Log::debug($value);
        // $result=preg_match("/^[A-Z]{1,3}$/",$value);
        // Log::debug("LNMAE");
        // Log::debug($result);
        // return $result;
        // return preg_match("/^[A-Z]{1,3}$/",$value);
    }
}
