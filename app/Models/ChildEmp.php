<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildEmp extends Emp
{
    use SoftDeletes;
    // Define the table name (if it's different from the plural of the model name)
    protected $table = 'emp';

    


    // Fields that are mass assignable
    protected $fillable = [
       
        'address',
        'date_of_joining',
       
    ];

    // Cast 'address' as JSON
    protected $casts = [
        'address' => 'array',
    ];



    // Relationships
    public function department()
    {
        return $this->belongsTo(Dept::class, 'code', 'code');
    }
}