<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emp', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('profile_pic')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('age');
            $table->json('address'); // Store address as JSON
            $table->date('date_of_joining');
            $table->string('code'); // Foreign key to the depts table
            $table->timestamps();
            $table->softDeletes('deleted_at');
            

            // Define the foreign key relationship
            $table->foreign('code')->references('code')->on('dept')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp');
        $table->dropSoftDeletes();
    }
};
