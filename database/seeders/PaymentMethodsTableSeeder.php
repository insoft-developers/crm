<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('payment_methods')->insert([
            [
                'name' => 'Tunai Keras',
                'code' => 'CASH_HARD',
                'description' => 'Pembayaran penuh langsung (100%)',
                'term_days' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '10:90 (Properti)',
                'code' => '10_90',
                'description' => 'DP 10% di awal, sisa 90% saat serah terima',
                'term_days' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '90 days from BL (Usance L/C)',
                'code' => '90_BL',
                'description' => 'Pembayaran 90 hari setelah tanggal Bill of Lading',
                'term_days' => 90,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cash in Advance',
                'code' => 'CIA',
                'description' => 'Pembeli bayar penuh sebelum barang dikirim',
                'term_days' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Open Account (30 days)',
                'code' => 'OA_30',
                'description' => 'Pembayaran 30 hari setelah pengiriman / invoice',
                'term_days' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
