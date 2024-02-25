<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Admin;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('aid');
            $table->string('username');
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('session_token')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('failed_password_count')->default(0);
            $table->string("profile_picture_url")->default("https://via.placeholder.com/30x30");
            $table->boolean("has_to_change_password")->default(true);
            $table->timestamps();
        });

        Admin::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make(env("DEFAULT_ADMIN_PASSWORD"), ['rounds' => 12])
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
