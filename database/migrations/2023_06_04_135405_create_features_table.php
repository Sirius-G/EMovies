<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('poster');
            $table->string('preview');
            $table->string('trailer');
            $table->string('feature');
            $table->string('certificate');
            $table->string('certificate_reasons');
            $table->string('feature_type');
            $table->string('writer_list');
            $table->string('actor_list');
            $table->string('producer_list');
            $table->string('short_description');
            $table->string('long_descrtiption');
            $table->string('free_paid');
            $table->string('price');
            $table->string('subscription_yn');
            $table->string('feature_length');
            $table->string('active');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
