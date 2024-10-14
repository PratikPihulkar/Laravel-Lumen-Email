<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp extends Model
{
    use SoftDeletes;
    // Define the table name (if it's different from the plural of the model name)
    protected $table = 'emp';

    


    // Fields that are mass assignable
    protected $fillable = [
        'employee_id',
        'profile_pic',
        'name',
        'email',
        'phone',
        'age',
        'address',
        'date_of_joining',
        'code'
    ];

    // Cast 'address' as JSON
    // protected $casts = [
    //     'address' => 'array',
    // ];



    // Relationships
    public function department()
    {
        return $this->belongsTo(Dept::class, 'code', 'code');
    }
}