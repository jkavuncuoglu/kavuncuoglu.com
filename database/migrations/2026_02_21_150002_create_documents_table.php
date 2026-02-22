<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('general');
            $table->text('content');
            $table->json('embedding')->nullable();
            $table->unsignedInteger('chunk_index')->default(0);
            $table->string('source')->nullable();
            $table->timestamps();

            $table->index(['type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
