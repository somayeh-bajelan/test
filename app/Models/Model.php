<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Abstract Model class, to add services functionality to the default models.
 *
 * @author  Somayeh Bajelan
 */
abstract class Model extends BaseModel
{
    /**
     * Service instances array.
     *
     * @var Service
     */
    protected $service;

    /**
     * Get service instance.
     *
     * @param null|string $serviceClass     The custom service class.
     * @return Service
     * @throws \Exception
     */
    public function getService($serviceClass = null)
    {
        $serviceClass = $serviceClass ?: $this->getServiceName();

        // we need to pass the model to the make function to create a service.
        $passingVariables = ['model' => $this];


        if (is_null($this->service)) {
            $this->service = app()->make($serviceClass, $passingVariables);
        }

        return $this->service;
    }

    /**
     * Get service class name. It should define statically on the model.
     *
     * @return string
     */
    abstract protected function getServiceName();
}