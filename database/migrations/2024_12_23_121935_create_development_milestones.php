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
        Schema::create('development_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')
                ->nullable()
                ->constrained('visits','id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('child_id')
                ->constrained('children','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('staff','id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('development_milestones');
    }
};
