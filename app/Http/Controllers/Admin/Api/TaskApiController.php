<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Interfaces\TaskRepositoryInterface;
use App\Models\Repositories\TaskRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskApiController extends Controller
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
        return response()->json($tasks);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return $this
     */
    public function store(Request $request)
    {
        dd($request->header());
        $data = $request->toArray();
        //Validated request inputs
        $validator = Validator::make($data, $this->taskRepository->CreateRules());

        if($validator->fails())
        {
            return  response()->json($validator->getMessageBag() , 422);
        }

        //Check permission
        if(!$this->checkPermission('create task for all' ,(int)$request->get('assigned_to')))
        {
            return redirect('/admin/tasks')->with('error', 'User can not edit task for this user');
        }

        $data['created_by'] = Auth::user()->id;
        $data['status'] = TaskRepositoryInterface::STATUS_CREATED;

        $task =  $this->taskRepository->create($data);
        return response()->json($task , 200);
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
            return  response()->json('User can not create task for this user' , 422);
        }
        return response()->json($task , 200);
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
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        dd($request->header());
        $data = $request->toArray();

        //Validated request inputs
        $validator = Validator::make($data, $this->taskRepository->updateRules());
        if($validator->fails())
        {
            return  response()->json($validator->getMessageBag() , 422);
        }

        //Check permission
        $task = $this->taskRepository->getModelById((int)$id);
        if(!$this->checkPermission('edit task for all' ,$task->assigned_to ))
        {
            return  response()->json('User can not edit task for this user' , 422);
        }

        $task->name = $request->get('name')?? null;
        $task->description = $request->get('description')?? null;
        $task->priority = $request->get('priority')?? null;
        $task->status = $request->get('status');
        $task->assigned_to = $request->get('assigned_to')?? null;
        $task->updated_by =Auth::user()->id?? null;

        $this->taskRepository->update($task);

        return response()->json($task , 200);
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
            return response()->json('User can not destroy task for this user' , 422);
        }
        $this->taskRepository->removeByModel($task);
        return response()->json('Task has been deleted Successfully' , 200);
    }

}
