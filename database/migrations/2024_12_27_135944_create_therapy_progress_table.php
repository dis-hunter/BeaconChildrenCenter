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
        Schema::create('therapy_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapy_need_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->text('session_details');
            $table->text('progress_notes');
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
        Schema::dropIfExists('therapy_progress');
    }
};
