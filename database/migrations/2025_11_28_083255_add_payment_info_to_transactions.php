<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->string('payment_url')->nullable(); // Link ke halaman bayar Tripay
        $table->text('qr_string')->nullable(); // String kode QRIS (opsional)
        $table->string('reference')->nullable(); // Kode referensi dari Tripay
    });
}

public function down()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['payment_url', 'qr_string', 'reference']);
    });
}
};
