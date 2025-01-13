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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('student_id')->unique();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete(); // Mengacu pada tabel classes
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); // Mengacu pada tabel users
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
        Schema::dropIfExists('students');
    }
};
