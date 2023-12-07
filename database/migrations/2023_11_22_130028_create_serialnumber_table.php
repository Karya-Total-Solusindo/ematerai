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
            $table->string('namejidentitas')->nullable();
            $table->string('noidentitas')->nullable();
            $table->string('namedipungut')->nullable();
            $table->set('use',[1,0])->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('documet_id')->nullable();
            $table->string('docid')->nullable();
            $table->string('nodoc')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            // $table->timestamps();
        });
        // add coloumn update
        // Schema::table('serialnumber', function($table)
        // {
        //     $table->string('phone_nr')->after('id');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serialnumber');
    }
    
};
