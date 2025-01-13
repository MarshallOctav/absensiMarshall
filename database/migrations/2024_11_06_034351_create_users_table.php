<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique()->nullable(); // untuk siswa saja
            $table->string('email')->unique()->nullable(); // untuk guru dan admin
            $table->string('password');
            $table->enum('role', ['guru', 'siswa', 'admin'])->default('siswa'); // Default role sebagai siswa
            $table->foreignId('class_id')->nullable()->constrained('classes')->cascadeOnDelete(); // untuk siswa saja, hapus jika kelas dihapus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
