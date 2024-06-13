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
        if ($this->request->is('post')) {
           
            $user = $this->Auth->identify();
            
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect(['controller' => 'Users', 'action' => 'display']);
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }   
    }
   public function add(){

    $this->viewBuilder()->enableAutoLayout(false);
    if($this->request->is('post')){

            $users_table = TableRegistry::getTableLocator()->get('Users');
            $users = $users_table->newEntity($this->request->getData());
            
            if ($users->getErrors()) {
                $result=$users->getErrors();
                $this->set('Users',$users);
                return $this->response->withType("application/json")->withStringBody(json_encode($result));
            } 
            else {
                $fname = $this->request->getData('fname');
                $lname = $this->request->getData('lname');    
                $email = $this->request->getData('email');
                $hashPswdObj = new DefaultPasswordHasher;
                $password = $hashPswdObj->hash($this->request->getData('password'));
                $address_line_1 = $this->request->getData('address_line_1');
                $address_line_2 = $this->request->getData('address_line_2');
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
                              
                if($users_table->save($users)){
                    $result=array('message','User is added');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
                else{
                    $result=array('message','User is not added');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
            }   
        }
    }
    public function display(){       
        $users=TableRegistry::getTableLocator()->get('Users');
        $query = $users
            ->find('all')
            ->contain(['Products']);
        foreach ($query as $user) {
        }
        $result = $query->all();
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }
}