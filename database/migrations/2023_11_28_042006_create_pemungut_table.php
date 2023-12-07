<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemungut', function (Blueprint $table) {
            $table->id();
            $table->string('namejidentitas')->nullable();
            $table->string('noidentitas')->nullable();
            $table->string('namedipungut')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment('user ematerai');
            $table->string('p_user')->comment('user peruri');
            $table->string('p_password')->comment('pwd peruri');
            $table->text('token')->nullable()->comment('token peruri');
            $table->set('active',[1,0])->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemungut');
    }
};
