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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')
                ->constrained('children','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('staff','id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('staff_id')
                ->constrained('staff','id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('appointment_title');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status');
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
        Schema::dropIfExists('appointments');
    }
};