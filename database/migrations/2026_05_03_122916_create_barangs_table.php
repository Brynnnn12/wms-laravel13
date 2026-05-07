<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');

            $table->foreignUuid('jenis_barang_id')->constrained()->restrictOnDelete();

            $table->integer('jml_barang')->default(0);

            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('harga_total', 15, 2)->default(0);

            $table->integer('masa_penyusutan')->default(0);
            $table->decimal('nilai_residual', 15, 2)->default(0);

            $table->string('label')->nullable();

            $table->foreignUuid('status_barang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('kondisi_barang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('nama_ruang_id')->nullable()->constrained()->nullOnDelete();

            $table->year('tahun_anggaran')->nullable();
            $table->date('tanggal_perolehan')->nullable();

            $table->timestamps();
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
