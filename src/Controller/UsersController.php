<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;
use CAke\Utility\Xml;
use Cake\Http\ServerRequest;
use App\Model\Users;
use Cake\Http\Response;
use Cake\Core\Exception\Exception;
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
        try{
            $this->viewBuilder()->enableAutoLayout(false);
            if($this->request->is('post')){
                $headers = $this->request->getHeaders();
                $contentType = ($headers['Content-Type']);
                $content_type = implode(',', $contentType);
                $users_table = TableRegistry::getTableLocator()->get('Users');
                if (strpos($content_type, 'application/xml') !== false || strpos($content_type, 'text/xml') !== false) {
                    $user=Xml::toArray(Xml::build($this->request->input()));
                    $user['user']['user_name']=$user['user']['fname'].' '.$user['user']['lname'];
                    $users = $users_table->newEntity($user['user']);
                    
                }
                else{
                    $this->request = $this->request->withData('user_name', $this->request->getData('fname') . ' ' . $this->request->getData('lname'));
                    $user=array('user'=>$this->request->getData());
                    $users = $users_table->newEntity($user['user']);            
                }
                if ($users->getErrors()) {
                    $result=$users->getErrors();
                    $this->set('Users',$users);
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                } 
                else{
                    $users->user_name =  $user['user']['user_name'];                     
                    $users->email = $user['user']['email'];
                    $hashPswdObj = new DefaultPasswordHasher;
                    $users->password = $hashPswdObj->hash($user['user']['password']);
                    $users->address_line_1 = $user['user']['address_line_1'];
                    $users->address_line_2 = $user['user']['address_line_2'];
                    $users->pincode = $user['user']['pincode'];
                    $users->phone_number = $user['user']['phone_number'];
                    Log::debug($users);
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
        catch(Exception $e){
            echo 'Error : '.'Check the request method'.' '.$e->getMessage();
            return;
        }
    }
    public function display(){      
        try{
            $users=TableRegistry::getTableLocator()->get('Users');
            $query = $users
                ->find('all')
                ->contain(['Products']);
            foreach ($query as $user) {
            }
            $result = $query->all();
            return $this->response->withType("application/json")->withStringBody(json_encode($result));
        }
        catch(Exception $e){
            echo 'Error : '.'Check the request method'.' '.$e->getMessage();
            return;
        }
        
    }
    public function update(){
        try{
            $this->viewBuilder()->enableAutoLayout(false);
            if($this->request->is('put')){
                $id = $this->request->getData('id');
                $address_line_2=$this->request->getData('address_line_2');
                $users_table = TableRegistry::getTableLocator()->get('Users');
                $users = $users_table->get($id); 
                if(isset($users->address_line_2)) {   
                    $users->address_line_2=$address_line_2;
                }
                else{
                    $users->address_line_2=$address_line_2;
                }
                $this->set('Users', $users);                
                if($users_table->save($users)){
                    $result=array('message','User is updated');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
                else{
                    $result=array('message','User is not updated');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
                
            } 
        }
        catch(Exception $e){
            echo 'Error : '.'Check the request method'.' '.$e->getMessage();
            return;
        }  
    }
    public function delete(){
       try{
            if($this->request->allowMethod(['delete'])){
                Log::debug($this->request->getData());
                $id = $this->request->getData('id');
                $users = $this->Users->get($id);   
                Log::debug($users);    
                if($this->Users->delete($users)){
                    $result=array('message','User is deleted');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
                else{
                    $result=array('message','User is not deleted');
                    return $this->response->withType("application/json")->withStringBody(json_encode($result));
                }
                
            }  
       } 
       catch(Exception $e){
            echo 'Error : '.'Check the request method'.' '.$e->getMessage();
            return;
        } 
    }
}