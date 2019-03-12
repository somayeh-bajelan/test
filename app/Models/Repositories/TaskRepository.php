<?php

namespace App\Models\Repositories;

use App\Models\Entities\Task;
use App\Models\Interfaces\TaskRepositoryInterface;
use App\Models\Repository;
use Illuminate\Support\Facades\Auth;


/**
 * Response Repository class.
 *
 * @author  Somayeh Bajelan
 */
class TaskRepository extends Repository implements TaskRepositoryInterface
{
    /**
     * Return the class path of repository's model.
     *
     * @return string
     */
    protected function getModelClass()
    {
        return Task::class;
    }

    /**
     * Returns all possible status for User entity.
     *
     * @return array
     */
    public static function getAllPossiblePriority(): array
    {
        return [
            static::PRIORITY_HIGH,
            static::PRIORITY_LOW,
            static::PRIORITY_NORMAL,
        ];
    }


    /**
     * Returns all possible status for User entity.
     * @return array
     * @internal param $role
     */
    public static function getAllPossibleStatusBaseOnRole(): array
    {
        $statuses = [];

        if(Auth::user()->hasPermissionTo(strtolower( static::STATUS_TODO)))
            $statuses[] = static::STATUS_TODO;

        if(Auth::user()->hasPermissionTo(strtolower( static::STATUS_DONE)))
            $statuses[] = static::STATUS_DONE;

        if(Auth::user()->hasPermissionTo(strtolower( static::STATUS_VERIFIED)))
            $statuses[] = static::STATUS_VERIFIED;


        return $statuses;
    }

}