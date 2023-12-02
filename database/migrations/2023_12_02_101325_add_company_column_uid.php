<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = "companies";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function ($table) {
            $table->string('uid')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function($table) {
            $table->dropColumn('uid');
        });
    }
};
