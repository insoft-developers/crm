<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductCodeGenerator
{
    /**
     * Generate product code.
     * Format: {PREFIX}-{YYYYMM}-{5 digit sequence}
     *
     * @param string $prefix
     * @param int $pad (jumlah digit sequence)
     * @return string
     */
    public static function generate($prefix = 'PRD', $pad = 5)
    {
        // gunakan tanggal current
        $now = Carbon::now();
        $period = $now->format('Ym'); // e.g. 202509
        $key = "{$prefix}-{$period}";

        // transaction + lock to avoid race condition
        return DB::transaction(function () use ($key, $prefix, $period, $pad) {
            // Ambil baris sequence, block dengan FOR UPDATE
            $row = DB::table('product_sequences')
                ->where('key', $key)
                ->lockForUpdate()
                ->first();

            if ($row) {
                $next = $row->last_number + 1;
                DB::table('product_sequences')
                    ->where('id', $row->id)
                    ->update([
                        'last_number' => $next,
                        'updated_at' => now()
                    ]);
            } else {
                $next = 1;
                DB::table('product_sequences')->insert([
                    'key' => $key,
                    'last_number' => $next,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            $sequence = str_pad($next, $pad, '0', STR_PAD_LEFT); // e.g. 00001
            return "{$prefix}-{$period}-{$sequence}";
        }, 5); // retry 5x bila deadlock (opsional)
    }
}
