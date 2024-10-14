<?php

namespace App\Http\Controllers;
use App\Models\Dept;
use App\Models\Emp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

//Get All Data By EmpId
  public function  getDetails($id) {
    
    $dept = Dept::find($id);    
   }
}
