<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;
use CAke\Utility\Xml;
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
            $user=Xml::toArray(Xml::build($this->request->input()));
            $fname=$user['user']['fname'];
            $lname=$user['user']['lname'];
            $user_name=$fname.' '.$lname;
            $user['user']['user_name']=$user_name;
            $users_table = TableRegistry::getTableLocator()->get('Users');
            $users = $users_table->newEntity($user['user']);
            if ($users->getErrors()) {
                Log::debug('if');
                $result=$users->getErrors();
                $this->set('Users',$users);
                return $this->response->withType("application/json")->withStringBody(json_encode($result));
            } 
            else {
                $user_name = $user['user']['user_name']; 
                $email = $user['user']['email'];
                $hashPswdObj = new DefaultPasswordHasher;
                $password = $hashPswdObj->hash($user['user']['password']);
                $address_line_1 = $user['user']['address_line_1'];
                $address_line_2 = $user['user']['address_line_2'];
                $pincode = $user['user']['pincode'];
                $phone_number = $user['user']['phone_number'];
                $users->user_name = $user_name;
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