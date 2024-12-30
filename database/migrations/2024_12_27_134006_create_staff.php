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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->json('fullname');
            $table->string('telephone')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('staff_no')->unique();
            $table->rememberToken();
            $table->foreignId('gender_id')
                ->constrained('gender','id')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('role_id')
                ->constrained('roles','id')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('specialization_id')
                ->nullable()
                ->constrained('doctor_specialization','id')
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
        Schema::dropIfExists('staff');
    }
};
