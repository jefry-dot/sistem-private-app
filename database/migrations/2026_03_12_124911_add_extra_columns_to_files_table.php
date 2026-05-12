<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('original_name');
            $table->text('description')->nullable()->after('display_name');
            $table->string('visibility')->default('private')->after('extension');
            $table->date('expires_at')->nullable()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'description', 'visibility', 'expires_at']);
        });
    }
};
