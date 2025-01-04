<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individualized_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('therapy_goals','id');
            $table->foreignId('child_id')->constrained('children','id');
            $table->foreignId('staff_id')->constrained('staff','id');
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individualized_plan');
    }
};
