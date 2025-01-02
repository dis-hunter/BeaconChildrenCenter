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
        Schema::create('triage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')
                ->nullable()
                ->constrained('visits','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('child_id')
                ->constrained('children','id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('staff','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->json('data');
            $table->foreignId('assessment_id')
                ->constrained('triage_assessment', 'id')
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
        Schema::dropIfExists('triage');
    }
};
