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
        Schema::create('penyesuaians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('stok_opname_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('barang_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('qty_sistem'); // Stok sebelum audit
            $table->integer('qty_fisik');  // Stok hasil audit
            $table->integer('selisih');    // Selisih (qty_fisik - qty_sistem)

            $table->text('keterangan')->nullable(); // Alasan misal: "Barang rusak/hilang"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyesuaians');
    }
};
