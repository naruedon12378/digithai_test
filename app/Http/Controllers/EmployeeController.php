<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $companyRepository;

    public function __construct(CompanyInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function list()
    {
        return view('master.employee');
    }
}
