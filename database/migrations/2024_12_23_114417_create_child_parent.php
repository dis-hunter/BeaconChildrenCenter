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
        Schema::create('child_parent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->constrained('parents','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('child_id')
                ->constrained('children','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('child_parent');
    }
};
