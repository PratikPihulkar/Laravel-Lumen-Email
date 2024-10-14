<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    // Define the table name (if it's different from the plural of the model name)
    protected $table = 'dept';

    // Fields that are mass assignable
    protected $fillable = [
        
        'd_name',
        'description',
        'code'
    ];

    // Relationships
    public function employees()
    {
        return $this->hasMany(Emp::class, 'code', 'code');
    }
}