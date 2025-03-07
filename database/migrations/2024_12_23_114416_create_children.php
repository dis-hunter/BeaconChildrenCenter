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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->json('fullname');
            $table->date('dob');
            $table->string('birth_cert')->unique();
            $table->foreignId('gender_id')
                ->constrained('gender','id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('registration_number')->unique();
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
        Schema::dropIfExists('children');
    }
};
