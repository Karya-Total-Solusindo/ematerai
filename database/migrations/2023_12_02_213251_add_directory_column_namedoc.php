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
        Schema::table('directories', function ($table) {
            $table->string('namadoc')->nullable()->comment('digunakan untuk mengisi parameter “namadoc” saat melakukan generate SN.');
            $table->string('namadoc_detail')->nullable()->comment('detail namadoc');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('directories', function($table) {
            $table->dropColumn('namadoc');
            $table->dropColumn('namadoc_detail');
        });
    }
};
