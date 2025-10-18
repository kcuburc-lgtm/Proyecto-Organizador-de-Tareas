<?php 

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Model;
use App\Entities\Task;
use CodeIgniter\Exceptions\PageNotFoundException;

class Tasks extends BaseController
{
    private $model;

    private $current_user;

    public function __construct()
    {
        helper('form');
        $this->model = new TaskModel; 
        $this->current_user = service('auth')->getCurrentUser();
    }

    public function index() 
    {
       $data = $this->model->paginateTasksByUserId($this->current_user->id);

       return view("Tasks/index", [
            'tasks' => $data,
            'pager' => $this->model->pager
        ]);
    }

     public function show($id) 
    {
       $task = $this->getTaskOr404($id);

        return view('Tasks/show',[
            'task' => $task
        ]);
    }

    public function new()
     {
        $task = new Task;
        
        return view('Tasks/new', [
            'task' => $task
        ]);
     }

     public function create()
{
    $task = new Task($this->request->getPost());

    $task->user_id = $this->current_user->id;

    if ($this->model->insert($task)) {
        return redirect()->to("/tasks/show/{$this->model->insertID}")
                         ->with('info', 'Task created successfully');
    } else {
        return redirect()->back()
                         ->with('errors', $this->model->errors())
                         ->with('warning', 'Invalid data')
                         ->withInput();
    } 
}
     public function edit($id) 
     {
         $task = $this->getTaskOr404($id);

        return view('Tasks/edit',[
            'task' => $task
        ]);
     }

     public function update($id)
     {
         $task = $this->getTaskOr404($id);

         $post = $this->request->getpost();
         unset($post['user_id']);

         $task->fill($post);

        if ( ! $task->hasChanged()) {

            return redirect()->back()
                             ->with('warning', 'Nothing to update')
                             ->withInput();
        }

        if ($this->model->save($task)) {

            return redirect()->to("/tasks/show/$id")
                             ->with('info', 'Task updated successfully');

        } else {

            return redirect()->back()
                             ->with('errors', $this->model->errors())
                             ->with('warning', 'Invalid data')
                             ->withInput();
        }
     } 
     
     public function delete($id) 
    {
        $model = new TaskModel();

        if ($this->request->getMethod(true) === 'POST' || $this->request->getMethod(true) === 'DELETE') { 
            
            $model->delete($id);

            return redirect()->to('/tasks')
                             ->with('info', 'Task deleted');
        }

        $task = $model->find($id);

        if (!$task) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Task with id $id not found");
        }

        return view('Tasks/delete', [
            'task' => $task
        ]);
    }

     private function getTaskOr404($id)
{
    /* 
    $task = $this->model->find($id);

    if ($task !== null && ($task->user_id !== $user->id)) {

        $task = null; 
    } 
    */

    $task = $this->model->getTaskByIdAndUserId($id, $this->current_user->id);

    if ($task === null) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Task with id $id not found");
    }

    return $task;
}
 }
