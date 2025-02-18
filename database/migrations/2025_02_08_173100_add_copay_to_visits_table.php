<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->boolean('has_copay')->default(false);
            $table->decimal('copay_amount', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['has_copay', 'copay_amount']);
        });
    }
};
