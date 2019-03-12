<?php

namespace App\Http\Controllers\Admin\Tasks;

use App\Http\Controllers\Admin\Tasks\Requests\TaskCreateRequest;
use App\Http\Controllers\Controller;
use App\Http\Exceptions\AdminUnauthorizedException;
use App\Models\Entities\Task;
use App\Models\Interfaces\TaskRepositoryInterface;
use App\Models\Repositories\TaskRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    public function store(TaskCreateRequest $request)
    {
        if(! Auth::user()->hasPermissionTo('create task for all') && (Auth::user()->id != (int)$request->get('assigned_to') ))
        {
            return redirect('/admin/tasks')->with('error', 'User can not create task for this user');
        }
        $data = $request->toArray();
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
        //
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
        if(! Auth::user()->hasPermissionTo('edit task for all') && (Auth::user()->id != $task->assigned_to ))
        {
            return redirect('/admin/tasks')->with('error', 'User can not edit task for this user');
        }
        $users = User::getAllAccessibleUsers();
        $statuses =$this->taskRepository->getAllPossibleStatusBaseOnRole();
        return view('admin.tasks.edit' , compact('statuses','users' , 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
