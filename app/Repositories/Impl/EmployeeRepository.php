<?php


namespace App\Repositories\Impl;

use App\Models\Employee;
use App\Repositories\EmployeeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository implements EmployeeInterface
{
    protected $model;

    public function __construct(Employee $model)
    {
       parent::__construct($model);
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('name', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAll($param): Collection
    {
        $data = DB::table('employees')
            ->select('*')
            ->where('record_status','=',1)
            ->where('first_name', 'like', '%' .$param['searchValue']. '%')
            ->orWhere('last_name', 'like', '%' .$param['searchValue']. '%')
            ->orWhere('email', 'like', '%' .$param['searchValue']. '%')
            ->orWhere('phone', 'like', '%' .$param['searchValue']. '%')
            ->get();
        return $data;
    }

}
