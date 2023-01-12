<?php


namespace App\Repositories\Impl;

use App\Models\Company;
use App\Repositories\CompanyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository implements CompanyInterface
{
    protected $model;

    public function __construct(Company $model)
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
        $data = DB::table('companies')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$param['searchValue']. '%')
            ->get();
        return $data;
    }

}
