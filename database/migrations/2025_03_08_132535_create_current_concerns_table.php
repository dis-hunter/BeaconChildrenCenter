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
        Schema::create('current_concerns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('visit_id')->constrained('visits','id');
                $table->foreignId('child_id')->constrained('children','id');
                $table->foreignId('staff_id')->constrained('staff','id');
                $table->json('data');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_concerns');
    }
};
