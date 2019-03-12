<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

/**
 * Abstract Repository class.
 * All accessing and modifying database should be done through the repositories.
 *
 * @author  Somayeh Bajelan
 */
abstract class Repository
{
    /**
     * Model instance.
     *
     * @var Model
     */
    protected $model;


    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Return the class path of repository's model.
     *
     * @return string
     */
    abstract protected function getModelClass();

    /**
     * Create new instance of model.
     */
    private function makeModel()
    {
        $model = app($this->getModelClass());

        if (!$model instanceof Model) {
            throw new \Exception("Invalid Eloquent model");
        }

        $this->model = $model;
    }

    /**
     * Returns the model.
     *
     * @return Model
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * Returns the model which fetched by id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModelById($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Insert new row to database, create its model object and return the inserted model.
     *
     * @param $data
     * @return Model
     */
    public function create($data)
    {
        return $this->getModel()->create($data);
    }

    /**
     * Update model.
     *
     * @param Model $model
     * @return bool
     */
    public function update($model)
    {
        return $model->save();
    }

    /**
     * Removes entity from database by passing model.
     *
     * @param Model $model
     * @return bool|null
     */
    public function removeByModel(Model $model)
    {
        return $model->delete();
    }

    /**
     * Removes entity from database by passing id.
     *
     * @param int $id
     * @return bool
     */
    public function removeById($id)
    {
        return ($this->getModel()->destroy($id) > 0);
    }

    /**
     * Removes entity from database by passing constraint array.
     *
     * @param array $constraints
     * @return int
     */
    public function remove($constraints)
    {
        $query = $this->getModel();

        // loop over all given constraints
        foreach ($constraints as $where) {
            $query = $query->where($where[0], $where[1], $where[2]);
        }
        return $query->delete();
    }

    /**
     * Get all rows using pagination.
     *
     * @param null|int $items
     * @param array $columns
     * @return mixed
     */
    public function getAll($items = 10, $columns = [])
    {
        if(Auth::user()->hasPermissionTo('get all tasks'))
        {
            return $this->getModel()->paginate(
                $items < 1 ? 10 : $items,
                count($columns) ? $columns : ['*']
            );
        }
        else
        {
            return $this->getModel()->where('assigned_to' ,Auth::user()->id )->paginate(
                $items < 1 ? 10 : $items,
                count($columns) ? $columns : ['*']
            );
        }

    }

    /**
     * Return the count of all records in this model.
     *
     * @return int
     */
    public function countAll()
    {
        return $this->getModel()->count();
    }
}