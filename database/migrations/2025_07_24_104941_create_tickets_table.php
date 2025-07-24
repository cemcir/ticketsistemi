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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticketId');
            $table->string('title','150');
            $table->string('description',500)->nullable();
            $table->enum('priority',['low','medium','high'])->default('low');
            $table->enum('status',['open','answered','closed'])->default('open');
            $table->unsignedBigInteger('adminId');
            $table->foreign('adminId')->references('adminId')->on('admins')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
