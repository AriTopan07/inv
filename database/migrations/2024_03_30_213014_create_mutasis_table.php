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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('from_ruangan_id')->nullable();
            $table->unsignedBigInteger('to_ruangan_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            // $table->integer('qty');
            $table->text('keterangan');
            $table->boolean('verified')->default(0);
            $table->timestamps();

            // Relasi dengan tabel barang
            $table->foreign('barang_id')->references('id')->on('barangs');

            // Relasi dengan tabel ruangan
            $table->foreign('from_ruangan_id')->references('id')->on('ruangans');
            $table->foreign('to_ruangan_id')->references('id')->on('ruangans');

            // Relasi dengan tabel user
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
