<?php

namespace App\Http\Controllers;

use App\Models\Emp;
use App\Models\Dept;
use App\Models\ChildEmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpController extends Controller
{

    private $level;
    private $interest;


public function pagination($page){
    $employee=Emp::paginate($page);
    return response()->json($employee);
}

//POST EMP
    public function postEmp(Request $request)  {
        $this->validate($request,[

           'employee_id' => 'string|max:100',
           'name' => 'string|max:100',
           'email' => 'email|max:100',
           'phone' => 'string|regex:/^[0-9]{10}$/',           // Required, 10-digit numeric string
           'age' => 'integer|min:18|max:65',                  // Required, integer between 18 and 65
           'address' => 'string|max:255',                     // Required, max 255 characters
           'date_of_joining' => 'date|before_or_equal:today', // Required, valid date and not in the future
           'code' => 'string|max:50',                         // Required, string with max length 50
           ]);
           try { 
                    $tempmVar= Emp::create($request->all());

                        return response()->json([
                            'status' => 'success',
                            'message' => [],
                            'data' => $tempmVar
                        ], 200);         
            }  
           catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while fetching employee details'
                    ]
                ],
                'data' => []
            ], 500);
        }   
    }

//GET SINGLE EMP
    public function getSingleEmp($id)  {
       try {
            $employee=Emp::find($id);
                if($employee){
                    return response()->json([
                        'status' => 'success',
                        'message' => [],
                        'data' => $employee
                    ], 200);
                }
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => [
                            [
                                'code' => 'bad_request',
                                'msg' => 'No employee details found'
                            ]
                        ],
                        'data' => []
                    ], 404);
                }
            return $employee;
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'An error occurred while fetching employee details'
                        ]
                    ],
                    'data' => []
                ], 500);
            }
    }

//GET ALL EMP
    public function getAllEmp()  {
        try {
            $employees = Emp::all(); 
            $pagination=true;
            if ($employees->isNotEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => [],
                    'data' => $employees
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'No employee details found'
                        ]
                    ],
                    'data' => []
                ], 404);
            }
        } 
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while fetching employee details'
                    ]
                ],
                'data' => []
            ], 500);
        }
    } 

//DELETE SINGLE USER  ( SOFT-DELETE )
    public function deleteSingleEmp($id)  {
        
       try {
        $employee=Emp::find($id);
            if ($employee) {
                $employee->delete();
                
                return response()->json([
                    'status' => 'success',
                    'message' => ['message' => 'Employee DELETED'],
                    'data' => []
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'No employee details found'
                        ]
                    ],
                    'data' => []
                ], 404);
            }
        } 
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while fetching employee details'
                    ]
                ],
                'data' => []
            ], 500);
        }
    }

//RESTORE DELETED EMP
    public function restoreEmp($id) {
      try {
        $employee = Emp::withTrashed()->find($id); // Find employee, including soft-deleted
            if ($employee && $employee->trashed()) {
                $employee->restore(); // Restore the employee
                return response()->json([
                    'status' => 'success',
                    'message' => ["Employee Restore Successfully"],
                    'data' => []
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'Employee not found or not deleted'
                        ]
                    ],
                    'data' => []
                ], 404);
                
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while fetching employee details'
                    ]
                ],
                'data' => []
            ], 500);
        }
    }
    
//FORCE DELETE
    public function forceDeleteEmp($id)  {
        
        try {
            $employee=Emp::find($id);

            if ($employee) {
                $employee->forceDelete();
                return response()->json([
                    'status' => 'success',
                    'message' => ['message' => 'Employee DELETED FORCEFULLY'],
                    'data' => []
                ], 200); 
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'No employee details found'
                        ]
                    ],
                    'data' => []
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while deleting employee forcefully'
                    ]
                ],
                'data' => []
            ], 500);
        }
    }

//UPDATE USER   (Inside Postman Use Row data in json format)
    public function updateEmp(Request $request, $id) {
        
            $this->validate($request,[

            'employee_id' => 'string|max:100',
            'name' => 'string|max:100',
            'email' => 'email|max:100',
            'phone' => 'string|regex:/^[0-9]{10}$/',           // Required, 10-digit numeric string
            'age' => 'integer|min:18|max:65',                  // Required, integer between 18 and 65
            'address' => 'string|max:255',                     // Required, max 255 characters
            'date_of_joining' => 'date|before_or_equal:today', // Required, valid date and not in the future
            'code' => 'string|max:50',                         // Required, string with max length 50
            ]);

        try {
            // Find the employee by ID
            $employee = Emp::find($id);

            // If employee is not found, return an error response
            if (!$employee) {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'No employee details found'
                        ]
                    ],
                    'data' => []
                ], 404);
            }

            $employee->update($request->all());
        
            return response()->json($employee, 200);

        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while fetching employee details'
                    ]
                ],
                'data' => []
            ], 500);
        }
    }

//Search Employee
    public function searchEmp(Request $request) {
        // Fetch all employees
        $employees = Emp::query();
        
        if ($request->has('name')) {
            $employees->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('employee_id')) {
            $employees->where('employee_id', 'like', '%' . $request->input('employee_id') . '%');
        }

        if ($request->has('email')) {
            $employees->where('email', 'like', '%' . $request->input('email') . '%');
        }

    
        $filteredEmployees = $employees->get();

        // Check if employees were found based on the search criteria
        if ($filteredEmployees->isNotEmpty()) {
            return response()->json($filteredEmployees);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'No employee found'
                    ]
                ],
                'data' => []
            ], 404);
        }
    }

//Sort emp
    public function sortEmp() {
        $sortedEmp= DB::select('select * from emp order by created_at desc');
            //return response()->json($sortedEmp);
        return response()->json([
            'status' => 'success',
            'message' => ['message' => 'Data SORTED '],
            'data' => [$sortedEmp]
            ], 200);
    } 
    
//Get Filtered Data  (Copied from Klyan)
    public function getFilteredData(Request $request){
        
        $filterParams = $request->input('filter_params', []);
        $dateRange = $filterParams['date'] ?? null;
        $pagination = $filterParams['pagination'] ?? true;  
        $search = $filterParams['search'] ?? null;
        $sorting = $filterParams['sorting'] ?? null;

        $query = DB::table('emp')
            ->join('dept', 'emp.code', '=', 'dept.code')
            ->select('emp.*', 'dept.d_name as d_name', 'dept.description as dept_description');


        if ($dateRange && count($dateRange) === 2) {
            $startDate = $dateRange[0] ?: null;  // Start 
            $endDate = $dateRange[1] ?: null;  // End 

            if ($startDate && $endDate) {
                $query->whereBetween('emp.date_of_joining', [$startDate, $endDate]);
            }
        }

      
        if ($search) {
            $query
                ->where('emp.name', 'LIKE', '%' . $search . '%')
                ->orWhere('emp.email', 'LIKE', '%' . $search . '%')
                ->orWhere('emp.phone', 'LIKE', '%' . $search . '%');
        }

        if ($sorting) {
            $column = $sorting['column'] ?? 'id'; 
            $order = $sorting['order'] ?? 'asc';  

            $query->orderBy($column, $order);
        }

        if ($pagination) {
            $perPage = $request->input('per_page', 3);  
            $result = $query->paginate($perPage);
        } else {
           
            $result = $query->get();
        }

        return response()->json(['status' => 'Success', 'data' => [$result]]);
    }

//For Desktop
    public function getFilteredDataAgain(Request $request) {

        $getData = $request->input('data', []);
        $pagination = $getData['pagination'] ?? true;
        $fields = $getData['fields'] ?? ['ALL'];  
        $date = $getData['filter_param']['date'] ?? [];
        $start = $getData['start'] ?? 1;
        $length = $getData['length'] ?? 5;
        $order = $getData['order'] ?? ['column' => 'emp.id', 'dir' => 'asc']; 
        
        $search = $getData['search']['value'] ?? null;
    
        $query = DB::table('emp')
                    ->join('dept', 'emp.code', '=', 'dept.code')
                    ->select('emp.*', 'dept.d_name as d_name', 'dept.description as dept_description');

      if (in_array('All', $fields)) {
        
            $query->select('emp.*', 'dept.d_name  as d_name', 'dept.description as dept_description');
        } else {
        
            $empFields = array_map(function($field) { return 'emp.' . $field; }, $fields);
            $query->select(array_merge($empFields, ['dept.d_name as d_name', 'dept.description as dept_description']));
        }
        
    
        if (!empty($date) && count($date) === 2) {
            $startDate = $date[0] ?: null;  
            $endDate = $date[1] ?: null;
    
            if ($startDate && $endDate) {
                $query->whereBetween('emp.date_of_joining', [$startDate, $endDate]);
            }
        }
    
        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('emp.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp.email', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp.address', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp.phone', 'LIKE', '%' . $search . '%');
            });
        }
    
        if( $order['column'] &&  $order['dir'] ){
            $column = $order['column'] ?? 'emp.date_of_joining';  
            $dir = $order['dir'] ?? 'asc';
            $query->orderBy($column, $dir);
        }
    
        if ($pagination) {
            $perPage = $request->input('per_page', 3);  
            $result = $query->paginate($perPage);
        } else {
            $result = $query->get();
        }
    
        $result = $query->paginate($length, ['*'], 'page', ceil(($start + 1) / $length));
        return response()->json(['status' => 'Success', 'data' => $result]);
    }
    
// new NOT Using Pagination
    public function getFilteredDataOffset(Request $request) {

        $getData = $request->input('data', []);
        $pagination = $getData['pagination'] ?? true;
        $fields = $getData['fields'] ?? ['ALL'];  
        $date = $getData['filter_param']['date'] ?? [];
        $start = $getData['start'] ?? 0;
        $length = $getData['length'] ?? 10;
        $order = $getData['order'] ?? ['column' => 'emp.id', 'dir' => 'asc']; 
        
        $search = $getData['search']['value'] ?? null;


        $pageStartFrom= ($start-1) * $length;
        
        
        $query = DB::table('emp')
        ->join('dept', 'emp.code', '=', 'dept.code')
        ->select('emp.*', 'dept.d_name as d_name', 'dept.description as dept_description');

    
        if (in_array('All', $fields)) {
            
                $query->select('emp.*', 'dept.d_name  as d_name', 'dept.description as dept_description');
            } else {
            
                $empFields = array_map(function($field) { return 'emp.' . $field; }, $fields);
                $query->select(array_merge($empFields, ['dept.d_name as d_name', 'dept.description as dept_description']));
            }
        

        if (!empty($date) && count($date) === 2) {
            $startDate = $date[0] ?: null;
            $endDate = $date[1] ?: null;

            if ($startDate && $endDate) {
                $query->whereBetween('emp.date_of_joining', [$startDate, $endDate]);
            }
        }

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('emp.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp.email', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp.address', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp.phone', 'LIKE', '%' . $search . '%');
            });
        }

        if( $order['column'] &&  $order['dir'] ){
            $column = $order['column'] ?? 'emp.date_of_joining';  
            $dir = $order['dir'] ?? 'asc';
            $query->orderBy($column, $dir);
        }

        if ($pagination) {
            $perPage = $request->input('per_page', 3);  
            $result = $query->paginate($perPage);
        } else {
            $result = $query->get();
        }

        $result = $query->offset($length, ['*'], 'page', ceil(($start + 1) / $length));
        return response()->json(['status' => 'Success', 'data' => $result]);
    }


}