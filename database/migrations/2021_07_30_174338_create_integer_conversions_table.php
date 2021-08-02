<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegerConversionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('integer_conversions', function (Blueprint $table) {
            $table->integer('integer_value')->primary();
            $table->string('converted_value')->unique();
            $table->integer('conversion_count')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integer_conversions');
    }
}
