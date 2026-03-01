<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string("surname");
                $table->string("username");
                $table->string("avatar_url")->default(null);
                $table->enum("role", ["user", "admin"])->default("user");
            });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('username');
            $table->dropColumn('avatar_url');
            $table->dropColumn('role');
        });
    }
};
