<?php

namespace App\Models\Interfaces;

interface TaskRepositoryInterface extends RepositoryInterface
{
    const STATUS_CREATED = 'Created';
    const STATUS_TODO = 'Todo';
    const STATUS_DONE = 'Done';
    const STATUS_VERIFIED = 'Verified';

    const PRIORITY_HIGH = 'High';
    const PRIORITY_LOW = 'Low';
    const PRIORITY_NORMAL = 'Normal';

    /**
     * Returns all possible priority for User entity.
     *
     * @return array
     */
    public static function getAllPossiblePriority(): array;

    /**
     * Returns all possible status for User entity.
     * @return array
     * @internal param $role
     */
    public static function getAllPossibleStatus(): array;

    /**
     * Returns Rules of creation task.
     * @return array
     */
    public function CreateRules():array ;

    /**
     * Returns Rules of edit task.
     * @return array
     */
    public function updateRules():array ;



}