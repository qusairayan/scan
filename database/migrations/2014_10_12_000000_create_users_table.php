<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');



            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('company_id');

            $table->string('otp')->nullable();
     

            $table->integer('status');
            $table->string('token');
            $table->integer('role');

            $table->date('started_at')->default(DB::raw('CURRENT_DATE'));;

        
           

            $table->timestamps();

          
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
