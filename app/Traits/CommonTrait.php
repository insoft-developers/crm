<?php

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;

trait CommonTrait
{
    public function set_owner_id($userid)
    {
        $user = User::find($userid);
        if ($user->position_id === 1) {
            return $user->id;
        } else {
            return $user->owner_id;
        }
    }

    public function hitung_jatuh_tempo($tanggalInput, int $jumlahHari): string
    {
        return Carbon::parse($tanggalInput)->addDays($jumlahHari)->format('Y-m-d');
    }
}
