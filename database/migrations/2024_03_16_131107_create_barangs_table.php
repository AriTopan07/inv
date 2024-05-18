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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('image')->nullable();
            $table->string('barcode')->unique();
            $table->string('nama');
            $table->string('merk');
            $table->string('tipe');
            $table->string('no_seri')->unique();
            $table->integer('harga');
            $table->integer('qty');
            $table->enum('kondisi', ['baik', 'cukup baik', 'rusak']);
            $table->text('deskripsi');
            $table->tinyInteger('status')->default(1);
            $table->boolean('verified')->default(0);
            $table->timestamps();

            // relation table
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->foreign('ruangan_id')->references('id')->on('ruangans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
