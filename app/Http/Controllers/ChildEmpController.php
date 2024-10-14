<?php

namespace App\Http\Controllers;



class ChildEmpController extends EmpController
{
    private $level;
    private $interest;

    public function inheritEmpDetails($id)
    {   
        
        $empDetails = $this->getSingleEmp($id);
        
        return $empDetails;

        // return response()->json($this->getSingleEmp($id));
    }

    public function checkEmpLevelInterest($level, $interest){
        

        //Trying Incapsulation
        $this->level=$level;
        $this->interest=$interest;

        return response()->json([
            'Message'=>'This is Class level Private Variables',
            'level' => $this->level,
            'interest' => $this->interest,
        ]);
        
        // return $this->level.$this->interest;
        // echo $level.$interest;
        $this->testtest();
    }

 public function testtest(){
        echo $this->level.$this->interest;
 }
        


}
