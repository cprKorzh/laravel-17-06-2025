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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('cargo_type');
            $table->decimal('weight_kg', 10, 2);
            $table->decimal('volume_m3', 10, 2);
            $table->string('from_address');
            $table->string('to_address');
            $table->date('date');
            $table->time('time');
            $table->string('status')->default('Новая');
            $table->timestamps();
            
            // Внешний ключ
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
