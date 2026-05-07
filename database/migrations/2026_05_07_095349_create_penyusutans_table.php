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
        Schema::create('penyusutans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('barang_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('bulan');
            $table->year('tahun');
            $table->decimal('nilai_awal', 15, 2);
            $table->decimal('nilai_penyusutan', 15, 2);
            $table->decimal('akumulasi_penyusutan', 15, 2);
            $table->decimal('nilai_buku', 15, 2);
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->unique(['barang_id', 'bulan', 'tahun']);
            $table->index(['bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyusutans');
    }
};
