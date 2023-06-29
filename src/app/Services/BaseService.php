<?php

namespace App\Services;

use Illuminate\Support\Arr;

class BaseService
{
    protected $model;

    /**
     * Constructor
     * 
     * @return Model
     */
    public function __construct()
    {
        $this->model = new $this->model();
    }

    /**
     * Get all records
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get a record by id
     * 
     * @param int $id this is the id of the record to be retrieved
     * 
     * @return Model
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record
     * 
     * @param array $data this is the payload to be used to create the record
     * 
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record
     * 
     * @param int   $id   this is the id of the record to be updated
     * @param array $data this is the payload to be used to update the record
     * 
     * @return Model
     */
    public function update($id, array $data)
    {
        $myArray = Arr::except($data, ['uuid']);

        return $this->model->find($id)->update($myArray);
    }

    /**
     * Delete a record
     * 
     * @param int $id this is the id of the record to be deleted
     * 
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Get a record by where clause
     * 
     * @param $key   this is the column of the record to be retrieved
     * @param $value this is the value of the record to be retrieved
     * 
     * @return Model
     */
    public function findByWhere($key, $value, $all = false)
    {

        return $all ? $this->model->where($key, $value)->get()
            : $this->model->where($key, $value)->first();
    }

    /**
     * Get a record count 
     * 
     * @param $key   this is the column of the record to be retrieved
     * @param $value this is the value of the record to be retrieved
     * 
     * @return Model
     */
    public function countType($key, $value)
    {
        return $this->model->where($key, $value)->count();
    }

    /**
     * Get a record by pagination
     * 
     * @param $number this is the pagination number to be received
     * 
     * @return Model model with pagination information
     */
    public function paginate($number)
    {
        return $this->model->paginate($number);
    }

    public function search($key)
    {
        return $this->model->query()
            ->where("created_by", "LIKE", "%{$key}%")
            ->orWhere("name", "LIKE", "%{$key}%")
            ->orWhere("gender", "LIKE", "%{$key}%")
            ->paginate(30);
    }
}
