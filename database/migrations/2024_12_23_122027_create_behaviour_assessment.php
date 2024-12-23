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
        Schema::create('behaviour_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits','id');
            $table->foreignId('child_id')->constrained('children','id');
            $table->foreignId('doctor_id')->constrained('doctors','id');
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
        Schema::dropIfExists('behaviour_assessment');
    }
};
