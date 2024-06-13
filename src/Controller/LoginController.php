<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Login Controller
 *
 *
 * @method \App\Model\Entity\Login[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LoginController extends AppController
{
   
   
        public function login()
        {
            // $users_table = TableRegistry::getTableLocator()->get('Users');
            // Log::debug(json_encode($users_table));
            // $user = $users_table->newEntity();
                
            // $user = $this->Users->newEntity();
            if ($this->request->is('post')) {
               
                // $users = $users_table->newEntity($this->request->getData());
                // Log::debug($user);
                $user = $this->Users->Auth->identify();
                Log::debug($user);
                if ($user) {
                    Log::debug('inside if');
                    $this->Auth->setUser($user);
                    // return $this->redirect($this->Auth->redirectUrl());
                    return $this->redirect(['controller' => 'Login', 'action' => 'display']);
                } else {
                    Log::debug('inside else');
                    $this->Flash->error(__('Username or password is incorrect'));
                }
            }   
        }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $login = $this->Login->newEntity();
    //     if ($this->request->is('post')) {
    //         $login = $this->Login->patchEntity($login, $this->request->getData());
    //         if ($this->Login->save($login)) {
    //             $this->Flash->success(__('The login has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The login could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('login'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Login id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $login = $this->Login->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $login = $this->Login->patchEntity($login, $this->request->getData());
    //         if ($this->Login->save($login)) {
    //             $this->Flash->success(__('The login has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The login could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('login'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Login id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
//     public function delete($id = null)
//     {
//         $this->request->allowMethod(['post', 'delete']);
//         $login = $this->Login->get($id);
//         if ($this->Login->delete($login)) {
//             $this->Flash->success(__('The login has been deleted.'));
//         } else {
//             $this->Flash->error(__('The login could not be deleted. Please, try again.'));
//         }

//         return $this->redirect(['action' => 'index']);
//     }
// }
}