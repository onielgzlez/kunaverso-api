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
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastnames')
                ->after('name')
                ->nullable();
            
            $table->string('username')
                ->after('lastnames');

            $table->string('phone')
                ->after('username')
                ->nullable();
            
            $table->date('birthday')->nullable();
            $table->longText('about')->nullable();
            $table->longText('photo_path')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'lastnames',
                'username',
                'phone',
                'birthday',
                'about',
                'photo_path',
                'status',
            ]);
        });
    }
};
