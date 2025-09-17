<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeliveryMethodsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $methods = [
            [
                'code' => 'EXW',
                'name' => 'Ex Works (Franco Pabrik)',
                'description' => 'Barang tersedia di gudang/pabrik penjual, pembeli tanggung semua biaya & risiko setelah itu.',
            ],
            [
                'code' => 'FOB',
                'name' => 'Free on Board (FOB)',
                'description' => 'Penjual menanggung biaya sampai barang naik ke kapal di pelabuhan asal.',
            ],
            [
                'code' => 'CFR',
                'name' => 'Cost and Freight (CFR)',
                'description' => 'Penjual bayar ongkos kapal sampai pelabuhan tujuan, risiko pindah saat barang naik kapal.',
            ],
            [
                'code' => 'CIF',
                'name' => 'Cost, Insurance & Freight (CIF)',
                'description' => 'Seperti CFR, tapi penjual juga tanggung asuransi sampai pelabuhan tujuan.',
            ],
            [
                'code' => 'DAP',
                'name' => 'Delivered at Place (Franco Gudang)',
                'description' => 'Barang dikirim sampai gudang pembeli, bea & pajak impor ditanggung pembeli.',
            ],
            [
                'code' => 'DDP',
                'name' => 'Delivered Duty Paid (DDP)',
                'description' => 'Penjual tanggung semua biaya & risiko, termasuk pajak & bea masuk, sampai gudang pembeli.',
            ],
            [
                'code' => 'FOT',
                'name' => 'Free on Truck (FOT)',
                'description' => 'Penjual menanggung sampai barang dimuat ke truk.',
            ],
            [
                'code' => 'CONS',
                'name' => 'Consignment Delivery',
                'description' => 'Barang dititipkan ke pembeli/agen, dibayar setelah terjual.',
            ],
        ];

        foreach ($methods as $method) {
            DB::table('delivery_methods')->updateOrInsert(
                ['code' => $method['code']], // kalau sudah ada, update
                array_merge($method, ['created_at' => $now, 'updated_at' => $now])
            );
        }
    }
}
