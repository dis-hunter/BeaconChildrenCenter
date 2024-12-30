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
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('staff','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('staff_id')
                ->constrained('staff','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
