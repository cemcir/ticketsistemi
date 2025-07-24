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
        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->id();
            $table->string('responseText',500);
            $table->unsignedBigInteger('ticketId');
            $table->unsignedBigInteger('adminId');
            $table->foreign('ticketId')->references('ticketId')->on('tickets')->onDelete('cascade');
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
        Schema::dropIfExists('ticket_responses');
    }
};
