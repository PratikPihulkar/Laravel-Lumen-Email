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
        Schema::create('dept', function (Blueprint $table) {
            $table->id();
            $table->string('d_name');
            $table->string('description')->nullable();
            $table->string('code');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('dept');
    }
};
