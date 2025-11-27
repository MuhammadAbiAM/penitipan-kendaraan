<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penitipan', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor');
            $table->string('merek')->nullable();
            $table->string('warna')->nullable();
            $table->dateTime('waktu_masuk')->default(now());
            $table->dateTime('waktu_keluar')->nullable();
            $table->decimal('total_biaya', 10, 2)->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->string('kode_struk')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penitipan');
    }
};
