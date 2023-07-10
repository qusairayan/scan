<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->time('time');
            $table->date('date');
            $table->time('period');
            $table->string('reason')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();



            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

  
    
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }

    
};
