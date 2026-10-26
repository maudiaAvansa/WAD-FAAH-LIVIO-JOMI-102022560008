<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 20)->unique();
            $table->string('nama', 100);
            $table->string('nik', 16)->nullable();
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('gol_darah', 3)->default('-');
            $table->string('no_hp', 20);
            $table->text('alamat');
            $table->string('kota', 50);
            $table->string('darurat_nama', 100);
            $table->string('darurat_hubungan', 20)->nullable();
            $table->string('darurat_hp', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};