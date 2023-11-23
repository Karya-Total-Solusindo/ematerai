<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $table = "document";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('directory_id');
            $table->string('docnumber');
            $table->double('x1')->comment('Lower Left X');
            $table->double('x2')->comment('Lower Left Y');
            $table->double('y1')->comment('Upper Right X');
            $table->double('y2')->comment('Upper Right Y');
            $table->double('height');
            $table->double('width');
            $table->integer('page');
            $table->string('source');
            $table->string('filename');
            $table->string('certificatelevel')->nullable();
            $table->string('sn')->nullable();
            $table->string('qr')->nullable();
            $table->string('spesimenPath')->nullable(); //qr path
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            // $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
