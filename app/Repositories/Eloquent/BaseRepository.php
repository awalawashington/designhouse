<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Arr;
use App\Repositories\Contracts\BaseInterface;
use App\Repositories\Criteria\InterfaceCriteria;


abstract class BaseRepository implements BaseInterface, InterfaceCriteria
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    public function all()
    {
        return $this->model->get();
    }

    public function find($id){
        return $this->model->findOrFail($id);
    }

    public function findWhere($column, $value){
        return $this->model->where($column, $value)->get();
    }
    
    public function findWhereFirst($column, $value){
        return $this->model->where($column, $value)->firstOrFail();
    }

    public function paginate($perPage = 10){
        return $this->model->paginate($perPage);
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update($id, array $data){
        $record = $this->find($id);
        $record->update($data);
    }

    public function delete($id){
        $record = $this->find($id);
        $record->delete($id);
    }

    public function withCriteria(... $criteria){
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }

        return $this;
    }



    protected function getModelClass()
    {
        if (!method_exists($this, 'model')) {
            throw new Exception('No model defined');
        }

        return app()->make($this->model());
    }
}