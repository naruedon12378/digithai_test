<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Repositories\EmployeeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    private $employeeRepository;
    public function __construct(EmployeeInterface $employeeRepository){
        $this->employeeRepository = $employeeRepository;
    }
    public function employeeList(Request $request)
    {
        $postData = $request->all();
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage,
        ];

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->employeeRepository->getAll($param)->count();

        // Fetch records
        $records = $this->employeeRepository->paginate($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function employeeCreate(Request $request)
    {
        DB::beginTransaction();
        $params = $request->all();
        $result = [];
        try {

            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
            ]);

            if($validated){
                $data =[
                    'first_name' => $params['first_name'],
                    'last_name' => $params['last_name'],
                    'company' => $params['company'],
                    'email' => $params['email'],
                    'phone' => $params['phone'],
                ];
                $create = Employee::create($data);

                $result['status'] = "success";
                DB::commit();
            }else{
                DB::rollBack();
            }

        } catch (\Exception $ex){
            $result['status'] = "failed";
            $result['message'] = $ex;
            DB::rollBack();
        }
        return $result;
    }

    public function employeeViewEdit(Request $request)
    {
        $params = $request->all();
        $data = $this->employeeRepository->find($params['id']);
        return $data;
    }

    public function employeeDelete(Request $request)
    {
        $params = $request->all();
        $data['record_status'] = 0;
        $data = $this->employeeRepository->update($params['id'],$data);
        return $data;
    }

    public function employeeEdit(Request $request)
    {
        DB::beginTransaction();
        $result = [];
        $params = $request->all();
        try {
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
            ]);

            if($validated){
                $data =[
                    'first_name' => $params['first_name'],
                    'last_name' => $params['last_name'],
                    'company' => $params['company'],
                    'email' => $params['email'],
                    'phone' => $params['phone'],
                ];
                $update = $this->employeeRepository->update($params['id'],$data);
                $result['status'] = "success";
                DB::commit();
            }else{
                DB::rollBack();
            }
        } catch (\Exception $ex){
            $result['status'] = "failed";
            $result['message'] = $ex;
            DB::rollBack();
        }
        return $result;
    }
}
