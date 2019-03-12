<?php

namespace App\Models\Interfaces;

use App\Models\Model;

/**
 * Interface RepositoryInterface. All the repositories should implement this interface.
 *
 * @author  Somayeh Bajelan
 */
interface RepositoryInterface
{
    /**
     * Returns the model which fetched by id.
     *
     * @param   int     $id     The model unique ID
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModelById($id);

    /**
     * Insert new row to database, create its model object and return the inserted model.
     *
     * @param   array   $data   The data array holds the attributes and their values.
     * @return Model
     */
    public function create($data);

    /**
     * Update model.
     *
     * @param   Model   $model  The modifies model.
     * @return bool
     */
    public function update($model);

    /**
     * Removes entity from database by passing model.
     *
     * @param   Model   $model  The model that should remove.
     * @return bool|null
     */
    public function removeByModel(Model $model);

    /**
     * Removes entity from database by passing id.
     *
     * @param   int     $id     The unique model ID.
     * @return bool
     */
    public function removeById($id);

    /**
     * Removes entity from database by passing constraint array.
     *
     * @param   array   $constraints Constraints array should be something like: [ ['column1_name', '=', 'value'] ]
     * @return int
     */
    public function remove($constraints);

    /**
     * Get all rows using pagination.
     * Note: Currently we use Eloquent ORM which gets the page number directly from the request.
     *
     * @param   null|int    $items  The numbers of item that needs to be fetched.
     * @param array $columns
     * @return mixed
     */
    public function getAll($items = 10, $columns = []);

    /**
     * Return the count of all records in this model.
     *
     * @return int
     */
    public function countAll();

}