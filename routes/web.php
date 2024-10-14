<?php
namespace App\Http\Controllers;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\ChildEmpController;
use App\Http\Controllers\EmailController;

use App\Http\Controllers\ComboController;
/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/', function () use ($router) {
    return $router->app->version();
});

////////////////////////MIDDLEWARE///////////////////////////////

$router->get('/testMiddleware' , ['middleware'=>['example'], function () use ($router) {
    return $router->app->version();
}]);

$router->group(['middleware' => 'example'],function () use ($router) {
    $router->get('/send_mail','EmailController@send_mail');
});

$router->get('/home', function (){
    return view('email');
});


// $router->get('/send_mail' , ['middleware'=>'example', 'EmailController@send_mail']);

// $router->get('/send_mail' , ['middleware'=>'email', 'EmailController@send_mail']);


$router->get('/getUserPassword', 'DeptController@getUserPassword');

// $router->post('/register', ['user'=>'UserController@register'] );



$router->get('/test2', function () use ($router) {
    return ['name'=>'Pratik Pihulkar'];
});





/////////////////////////////// EMPLOYEE /////////////////////////

// pagination 
$router->get('/pagination/{page}', 'EmpController@pagination');

//getFilteredData
$router->get('/getFilteredData', 'EmpController@getFilteredData');

//getFilteredDataAgain
$router->get('/getFilteredDataAgain', 'EmpController@getFilteredDataAgain');

//getFilteredDataOffset
$router->get('/getFilteredDataOffset', 'EmpController@getFilteredDataOffset');



//Post Employee
$router->post('/postEmp', 'EmpController@postEmp');

// get Single Employee
$router->get('/getSingleEmp/{id}', 'EmpController@getSingleEmp');

// get All Employee
$router->get('/getAllEmp', 'EmpController@getAllEmp');

// Search EMp
$router->get('/searchEmp', 'EmpController@searchEmp');



// Sort Emp
$router->get('/sortEmp', 'EmpController@sortEmp');

// delete Single Employee
$router->delete('/deleteSingleEmp/{id}', 'EmpController@deleteSingleEmp');

// restore single employee By Id
$router->post('/restoreEmp/{id}', 'EmpController@restoreEmp');

// Force Delete
$router->delete('/forceDeleteEmp/{id}', 'EmpController@forceDeleteEmp');

// UPDATE Emp (Inside Postman Use Row data in json format)
$router->put('/updateEmp/{id}', 'EmpController@updateEmp');



///////////////////////////// DEPT //////////////////////////////

//Post Department
$router->post('/postDept', 'DeptController@postDept');

// get Single Department
$router->get('/getSingleDept/{id}', 'DeptController@getSingleDept');

// get All Department
$router->get('/getAllDept', 'DeptController@getAllDept');

// delete single Department
$router->delete('/deleteDept/{id}', 'DeptController@deleteDept');

// restore deleted Department(NOT WORK table not soft delet support)
$router->post('/restoreDept/{id}', 'DeptController@restoreDept');

//updete Dept (Inside Postman Use Row data in json format)
$router->put('/updateDept/{id}', 'DeptController@updateDept');



///////////////////////////// COMBO //////////////////////////////

// get All detais
$router->get('/getDetails/{id}', 'ComboController@getDetails');


//////////////////////////////ChildEmp ///////////////////////////

// Route::get('/child-emp/{id}', [ChildEmpController::class, 'inheritEmpDetails']);
$router->get('/inheritEmpDetails/{id}', 'ChildEmpController@inheritEmpDetails');



$router->get('/checkEmpLevelInterest/{level}/{interest}', 'ChildEmpController@checkEmpLevelInterest');

$router->get('/checkEmpLevelInterest/{level}', 'ChildEmpController@checkEmpLevelInterest');


