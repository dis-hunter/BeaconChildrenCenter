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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date');
            $table->string('source_type');
            $table->string('source_contact');
            $table->foreignId('visit_type')
                ->constrained('visit_type','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('child_id')
                ->constrained('children','id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('staff_id')
                ->constrained('staff','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('doctor_id')
                ->constrained('staff','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('visits');
    }
};
