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
            $table->text('lastnames')
                ->after('name')
                ->nullable();
            
            $table->text('username')
                ->after('lastnames');

            $table->text('phone')
                ->after('username')
                ->nullable();
            
            $table->date('brithday')->nullable();
            $table->longText('about')->nullable();
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
                'brithday',
                'about'
            ]);
        });
    }
};
