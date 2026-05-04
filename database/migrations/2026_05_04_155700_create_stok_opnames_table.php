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
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained()
                ->index()
                ->nullOnDelete();

            $table->date('tanggal_so');
            $table->foreignUuid('nama_ruang_id')->nullable()->constrained()->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};
