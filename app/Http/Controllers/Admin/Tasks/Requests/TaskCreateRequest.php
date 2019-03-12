<?php

namespace App\Http\Controllers\Admin\Tasks\Requests;

use App\Models\Interfaces\TaskRepositoryInterface;
use App\Models\Repositories\TaskRepository;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/*
 *
 * for validate fields in create announcement
 *
 */

class TaskCreateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'assigned_to' => ['required', 'in:' . implode(',', array_keys(User::getAllAccessibleUsers()))],
            'priority' => ['required', 'in:' . implode(',', $this->taskRepository->getAllPossiblePriority())],
        ];

    }
}
