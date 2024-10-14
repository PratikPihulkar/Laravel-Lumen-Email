<?php

namespace App\Http\Controllers;

use App\Models\Dept;
use App\Models\Emp;
use App\Models\ChildEmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeptController extends Controller
{
   

  
//POST DEPT
public function postDept(Request $request) {
    try {
        // Create a new department
        $dept = Dept::create($request->all());

        // Return success response if creation is successful
        return response()->json([
            'status' => 'success',
            'message' => [],
            'data' => $dept
        ], 201); // 201 status for successful creation

         } catch (\Exception $e) {
        // Return custom error response in case of an exception
        return response()->json([
            'status' => 'error',
            'message' => [
                [
                    'code' => 'bad_request',
                    'msg' => 'Something went wrong, try again later'
                ]
            ],
            'data' => []
        ], 500); // 500 Internal Server Error
    }
}


//GET SINGLE DEPT
public function getSingleDept($id) {
    try {
      
        $dept = Dept::find($id);

       
        if ($dept) {
            return response()->json([
                'status' => 'success',
                'message' => [],
                'data' => $dept
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => [
                [
                    'code' => 'bad_request',
                    'msg' => 'Department not found'
                ]
            ],
            'data' => []
        ], 404);

    } catch (\Exception $e) {
       
        return response()->json([
            'status' => 'error',
            'message' => [
                [
                    'code' => 'bad_request',
                    'msg' => 'Unauthorized'
                ]
            ],
            'data' => []
        ], 500); 
    }
}

//GET ALL DEPT
public function getAllDept() {
    try {
        $department = Dept::all();
        if ($department->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => [],
                'data' => $department
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'No department found'
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
                    'msg' => 'Something went wrong, try again later'
                ]
            ],
            'data' => []
        ], 500);
    }
}

//DELETE SINGLE DEPT  ( SOFT-DELETE ) (NOT SUPPORTED)
public function deleteDept($id) {
    try {
        $department = Dept::find($id);

        if ($department) {
            $department->delete();
            return response()->json([
                'status' => 'success',
                'message' => [
                    [
                        'code' => 'success',
                        'msg' => 'Department record deleted'
                    ]
                ],
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'No department found'
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
                    'msg' => 'Something went wrong, try again later'
                ]
            ],
            'data' => []
        ], 500);
    }
}

//RESTORE DELETED Dept
public function restoreDept($id) {
    try {
        $department = Dept::withTrashed()->find($id); 

        if ($department && $department->trashed()) {
            $department->restore(); 
            return response()->json([
                'status' => 'success',
                'message' => [
                    [
                        'code' => 'success',
                        'msg' => 'Department restored successfully'
                    ]
                ],
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'Department not found or not deleted'
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
                    'msg' => 'Problem in restoring deleted data'
                ]
            ],
            'data' => []
        ], 500);
    }
}

//UPDATE USER    (Inside Postman Use Row data in json format)
public function updateDept(Request $request, $id) {
        $this->validate($request, [
            'd_name' => 'string|max:100',
            'description' => 'string|max:100',
            'code' => 'string|max:50',
        ]);

        try {
            $department = Dept::find($id);

            if (!$department) {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                        [
                            'code' => 'bad_request',
                            'msg' => 'Department not found'
                        ]
                    ],
                    'data' => []
                ], 404);
            }

            $department->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => [],
                'data' => $department
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    [
                        'code' => 'bad_request',
                        'msg' => 'An error occurred while updating department'
                    ]
                ],
                'data' => []
            ], 500);
        }
}



}
