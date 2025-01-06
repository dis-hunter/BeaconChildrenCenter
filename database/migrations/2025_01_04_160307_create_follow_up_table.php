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
     //id
// child_id
// staff_id
// therapy_id
// data
// created_at
// updated_at
// visit_id
    public function up()
    {
        Schema::create('follow_up', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children','id');
            $table->foreignId('staff_id')->constrained('staff','id');
            $table->foreignId('therapy_id')->constrained('therapy','id');
            $table->json('data');
            $table->timestamps();
            $table->foreignId('visit_id')->constrained('visits','id');});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_up');
    }
};
