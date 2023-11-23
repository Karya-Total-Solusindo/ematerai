<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $table = "serialnumber";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('serialnumber', function (Blueprint $table) {
            $table->id();
            $table->string('sn');
            $table->text('image');
            $table->set('use',[1,0])->default(0);
            $table->unsignedBigInteger('documet_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serialnumber');
    }
};
