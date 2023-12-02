<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = "document";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('document', function ($table) {
           $table->string('massage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document', function($table) {
            $table->dropColumn('massage');
        });
    }
};
