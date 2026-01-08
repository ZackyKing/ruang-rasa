<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_profile_hidden')->default(false)->after('cover_photo');
            $table->string('language', 5)->default('id')->after('is_profile_hidden');
            $table->string('website')->nullable()->after('language');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_profile_hidden', 'language', 'website']);
        });
    }
};
