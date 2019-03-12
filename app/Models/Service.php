<?php

namespace App\Models;

use App\Models\Interfaces\RepositoryInterface;

/**
 * Abstract Service class.
 *
 * @author  Somayeh Bajelan
 */
abstract class Service
{
    /**
     * Repository instance
     *
     * @var Repository
     */
    protected $repository;

    /**
     * RepositoryObject instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * BaseService constructor.
     *
     * @param RepositoryInterface $repository
     * @param Model $model
     */
    public function __construct(RepositoryInterface $repository, Model $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Return the associated repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Returns the associated model.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
}