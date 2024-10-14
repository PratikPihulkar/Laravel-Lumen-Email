<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


class ComboController extends Controller
{
    
    public function getDetails($id)
    {
        $employee = DB::select('SELECT emp.*, dept.d_name 
                                FROM emp 
                                INNER JOIN dept
                                ON emp.code = dept.code
                                WHERE emp.id = ?', [$id]
                               );
                                
        return response()->json($employee);
    }
    

    
}
