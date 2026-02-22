<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('uploaded_file_id')->nullable()->after('source')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->after('uploaded_file_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['uploaded_file_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['uploaded_file_id', 'user_id']);
        });
    }
};
