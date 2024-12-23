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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->json('fullname');
            $table->date('dob');
            $table->foreignId('gender_id')->constrained('gender','id');
            $table->string('telephone');
            $table->string('email');
            $table->string('national_id');
            $table->string('employer')->nullable();
            $table->string('insurance')->nullable();
            $table->string('referer')->nullable();
            $table->foreignId('relationship_id')->constrained('relationships','id');
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
        Schema::dropIfExists('parents');
    }
};
