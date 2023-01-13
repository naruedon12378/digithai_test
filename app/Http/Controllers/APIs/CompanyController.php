<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\CompanyInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    private $companyRepository;
    public function __construct(CompanyInterface $companyRepository){
        $this->companyRepository = $companyRepository;
    }
    public function companyList(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->companyRepository->getAll($param)->count();

        // Fetch records
        $records = $this->companyRepository->paginate($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function companyCreate(Request $request)
    {
        DB::beginTransaction();
        $params = $request->all();
        $result = [];
        try {

            $validated = $request->validate([
                'name' => 'required',
                'logo' => 'dimensions:min_width=100,min_height=100',
            ]);

            if($validated){
                $data =[
                    'name' => $params['name'],
                    'website' => $params['website'],
                    'email' => $params['email'],
                    'address' => $params['address'],
                ];
                if ( $request->hasFile('logo') ) {
                    $destination_path = 'public/company-logo/';
                    $logo = $request->file('logo');
                    $logo_name = date('Ymd_His') . '_' .$logo->getClientOriginalName();
                    $path = $logo->storeAs($destination_path, $logo_name);
                    $data['logo'] = $logo_name;
                }
                $create = Company::create($data);

                $result['status'] = "success";
                DB::commit();
            }else{
                DB::rollBack();
            }

        } catch (\Exception $ex){
            dd($ex);
            $result['status'] = "failed";
            $result['message'] = $ex;
            DB::rollBack();
        }
        return $result;
    }

    public function companyViewEdit(Request $request)
    {
        $params = $request->all();
        $data = $this->companyRepository->find($params['id']);
        return $data;
    }

    public function companyDelete(Request $request)
    {
        $params = $request->all();
        $data['record_status'] = 0;
        $data = $this->companyRepository->update($params['id'],$data);
        return $data;
    }

    public function companyEdit(Request $request)
    {
        DB::beginTransaction();
        $result = [];
        $params = $request->all();
        try {
            //old_img
            $company = $this->companyRepository->find($request->id);
            $old_img = $company['logo'];

            $validated = $request->validate([
                'name' => 'required',
                'logo' => 'dimensions:min_width=100,min_height=100',
            ]);

            if($validated){
                $data =[
                    'name' => $params['name'],
                    'website' => $params['website'],
                    'email' => $params['email'],
                    'address' => $params['address'],
                ];
                if ( $request->hasFile('logo') ) {
                    $destination_path = 'public/company-logo/';
                    $logo = $request->file('logo');
                    $logo_name = date('Ymd_His') . '_' .$logo->getClientOriginalName();
                    $path = $logo->storeAs($destination_path, $logo_name);
                    $data['logo'] = $logo_name;
                }else{
                    $data['image'] = $old_img;
                }
                $update = $this->companyRepository->update($params['id'],$data);
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
