<?php

namespace App\Http\Controllers\Admin\Web;


use App\Http\Controllers\Admin\Requests\Task\TaskCreateRequest;
use App\Http\Controllers\Admin\Requests\Task\TaskUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Interfaces\TaskRepositoryInterface;
use App\Models\Repositories\TaskRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;


    /**
     *
     * UserController constructor.
     * @param TaskRepositoryInterface|TaskRepository $taskRepository
     * @internal param TaskRepository $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->taskRepository->getAll();
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::getAllAccessibleUsers();
        return view('admin.tasks.create' , compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskCreateRequest|Request $request
     * @return $this
     */
    public function store(Request $request)
    {
        'sd'fsdfsdfdsfsd'sdf'
        $data = $request->toArray();
        $validator = Validator::make($data, $this->taskRepository->updateRules());
        if($validator->fails())
        {
            return redirect('/admin/tasks')->with('errors', $validator->getMessageBag()->getMessages());
        }
        if(!$this->checkPermission('create task for all' ,(int)$request->get('assigned_to')))
        {
            return redirect('/admin/tasks')->with('error', 'User can not edit task for this user');
        }

        $data['created_by'] = Auth::user()->id;
        $data['status'] = TaskRepositoryInterface::STATUS_CREATED;

        $this->taskRepository->create($data);
        return redirect('/admin/tasks')->with('success', 'Task is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $task = $this->taskRepository->getModelById($id);
        if(!$this->checkPermission('show all task' ,$task->assigned_to))
        {
            return redirect('/admin/tasks')->with('error', 'User can not edit task for this user');
        }
        return view('admin.tasks.show' , compact( 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->taskRepository->getModelById($id);
        if(!$this->checkPermission('edit task for all' ,$task->assigned_to ))
        {
            return redirect('/admin/tasks')->with('error', 'User can not edit task for this user');
        }
        $users = User::getAllAccessibleUsers();
        $statuses =$this->taskRepository->getAllPossibleStatus();
        return view('admin.tasks.edit' , compact('statuses','users' , 'task'));
    }

    public function checkPermission($permission , $assigned_to)
    {
        $access = true;
        if(! Auth::user()->hasPermissionTo($permission) && (Auth::user()->id != $assigned_to ))
        {
            $access= false;
        }
        return $access;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskUpdateRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = $this->taskRepository->getModelById($id);
        if(!$this->checkPermission('edit task for all' ,$task->assigned_to ))
        {
            return redirect('/admin/tasks')->with('error', 'User can not edit task for this user');
        }

        $task->name = $request->get('name');
        $task->description = $request->get('description');
        $task->priority = $request->get('priority');
        $task->status = $request->get('status');
        $task->assigned_to = $request->get('assigned_to');
        $task->updated_by =Auth::user()->id;

        $this->taskRepository->update($task);

        return redirect('/admin/tasks')->with('success', 'Task is successfully edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->getModelById($id);
        if(!$this->checkPermission('delete all task' ,$task->assigned_to ))
        {
            return redirect('/admin/tasks')->with('error', 'User can not destroy task for this user');
        }
        $this->taskRepository->removeByModel($task);
        return redirect('/admin/tasks')->with('success', 'Task has been deleted Successfully');
    }
}
