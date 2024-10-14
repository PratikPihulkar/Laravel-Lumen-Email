<?php

namespace App\Http\Controllers;

use App\Models\Emp;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use Mail;
use App\Mail\DemoMail;



class EmailController extends Controller
{

  
    //     public function send_mail(Request $req)
    // {
    //     $employee = Emp::find($req->id);
    
        
    //     if (!$employee) {
    //         return response("Employee not found.", 404);
    //     }

    //     return $req->id;
    // }
public function send_mail(Request $req)
{
    $employee = Emp::find($req->id);

    if (!$employee) {
        return response("Employee not found.", 404);
    }

    // Define the mail data
    $mailData = [
        'title' => 'Mail From ' . $employee->name,
        'body'  => 'This is a test email sent from Lumen'
    ];

    // Send the email
    Mail::to($employee->email)->send(new DemoMail($mailData));

    return response('Email is sent successfully!', 200);
}



}
