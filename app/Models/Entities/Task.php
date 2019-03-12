<?php

namespace App\Models\Entities;

use App\Models\Model;
use Bamilo\Marco\Models\Services\TaskService;
use Spatie\Permission\Traits\HasRoles;

class Task extends Model
{
    use HasRoles;

    protected function getServiceName()
    {
        return TaskService::class;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'priority',
        'status' ,
        'assigned_to',
        'created_by',
        'updated_by'
    ];
}
