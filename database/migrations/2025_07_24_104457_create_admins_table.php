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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('adminId');
            $table->string('username',50);
            $table->string('password',500);
            $table->string('name',50);
            $table->string('surname',50);
            $table->string('email',100);
            $table->string('phone',20);
            $table->enum('role',['admin','user'])->default('user');
            $table->boolean('isActive')->default(\Illuminate\Support\Facades\DB::raw("true"));
            $table->timestamp('lastLoginDate')->nullable(); // sisteme son giriş tarihi
            $table->string('image',255)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
