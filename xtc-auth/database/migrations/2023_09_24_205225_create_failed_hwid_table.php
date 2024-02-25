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
        Schema::create('failed_hwid', function (Blueprint $table) {
            $table->id('fhid');
            $table->integer('uid');
            $table->string('core_count');
            $table->string('disk_serial');
            $table->string('mainboard_name');
            $table->string('winuser');
            $table->string('hwid_hash');
            $table->string('guid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_hwid');
    }
};
