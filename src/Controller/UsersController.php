<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;
use App\Model\Users;
use Cake\Http\Response;
class UsersController extends AppController{
    public function isAuthorized($user)
    {
        return true;
    }
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }
    public function login()
    {
        Log::debug('login');
        // $users_table = TableRegistry::getTableLocator()->get('Users');
        // Log::debug(json_encode($users_table));
        // $user = $users_table->newEntity();
            
        // $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
           
            // $users = $users_table->newEntity($this->request->getData());
            Log::debug('user');
            $user = $this->Auth->identify();
            Log::debug($user);
            if ($user) {
                Log::debug('inside if');
                $this->Auth->setUser($user);
                // return $this->redirect($this->Auth->redirectUrl());
                return $this->redirect(['controller' => 'Users', 'action' => 'display']);
            } else {
                Log::debug('inside else');
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }   
    }

    // public function login1()
    // {
    //     $authentication = $this->request->getAttribute('authentication');
    //     $result = $authentication->getResult();

    //     // regardless of POST or GET, redirect if user is logged in
    //     if ($result->isValid()) {

    //         // Assuming you are using the `Password` identifier.
    //         if ($authentication->identifiers()->get('Password')->needsPasswordRehash()) {
    //             // Rehash happens on save.
    //             $user = $this->Users->get($this->Auth->user('id'));
    //             $user->password = $this->request->getData('password');
    //             $this->Users->save($user);
    //         }

    //         // Redirect or display a template.
    //     }
    // }
   public function add(){
    Log::debug('inside function');
    // $this->autoLayout(false);
    // $this->autoRender = false;
    $this->viewBuilder()->enableAutoLayout(false);
    // Log::debug('function called');
    // return null;
    // $user=$this->Users->newEntity();
            // $categoriesTable = $this->fetchTable('Categories');
            // $categoryEnt = $categoriesTable->newEmptyEntity();
    // $users= $this->fetchTable('users');
    // $categoryEnt = $categoriesTable->newEmptyEntity();
    // if ($this->request->is('post')) {
    //     $category = $categoriesTable->patchEntity($categoryEnt, $this->request->getData());
    //     if ($categoriesTable->save($category)) {
    //         $responseBody = [
    //             'status' => 201,
    //             'data' => $category
    //         ];
    //     }else{
    //         $responseBody = [
    //             'status' => 400,
    //             'data' => $category->getErrors()
    //         ];
    //     }
    // // }
    // $this->set(compact('responseBody'));
    // $this->viewBuilder()->setOption('serialize', ['responseBody']);
        if($this->request->is('post')){
            // print_r( $this->request->getData());
            Log::debug('before new entity');

            $users_table = TableRegistry::getTableLocator()->get('Users');
            // print_r($users_table);
            $users = $users_table->newEntity($this->request->getData());
            Log::debug($users);
            Log::debug('after new entity');
            if ($users->getErrors()) {
                Log::debug('getErrors');
                $result=$users->getErrors();
                Log::debug($result);
                $this->set('Users',$users);
                return $this->response->withType("application/json")->withStringBody(json_encode($result));
            } 
            else {
                Log::debug('else');
                $fname = $this->request->getData('fname');
                $lname = $this->request->getData('lname');    
                $email = $this->request->getData('email');
                $hashPswdObj = new DefaultPasswordHasher;
                $password = $hashPswdObj->hash($this->request->getData('password'));
                $address_line_1 = $this->request->getData('address_line_1');
                Log::debug('before address 2');
                $address_line_2 = $this->request->getData('address_line_2');
                Log::debug('after address 2');
                $pincode = $this->request->getData('pincode');
                $phone_number = $this->request->getData('phone_number');
                $users->user_name = $fname.' '.$lname;
                $users->email = $email;
                $users->password = $password;
                $users->address_line_1 = $address_line_1;
                $users->address_line_2 = $address_line_2;
                $users->pincode = $pincode;
                $users->phone_number = $phone_number;
                $this->set('Users', $users);
                Log::debug('before save');
                Log::debug($users);
                // $users_table->save($users);
               
                
                // $users_table->save($users);
                if($users_table->save($users)){
                    Log::debug('after save');
                    Log::debug('inside if');
                    // echo "User is added.";
                    $result=array('message','User is added');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
                else{
                    Log::debug('inside else');
                    $result=array('message','User is not added');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
            }   
        }
    }
    public function display(){
        log::debug("inside display");
       
        $users=TableRegistry::getTableLocator()->get('Users');
        $query = $users
            ->find('all')
            ->contain(['Products']);
        foreach ($query as $user) {
            Log::debug(json_encode($user->products[0]->text));
        }
        $result = $query->all();
        Log::debug(json_encode($result));
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }
}