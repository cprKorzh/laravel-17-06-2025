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
        Schema::table('users', function (Blueprint $table) {
            // Добавляем новые поля
            $table->string('login')->unique()->after('id');
            $table->string('tel')->after('name');
            $table->string('role')->default('user')->after('password');
            
            // Переименовываем поле name в fullname
            $table->renameColumn('name', 'fullname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Возвращаем исходное состояние
            $table->renameColumn('fullname', 'name');
            $table->dropColumn('login');
            $table->dropColumn('tel');
            $table->dropColumn('role');
        });
    }
};
