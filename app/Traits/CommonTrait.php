<?php

namespace App\Traits;

use App\Models\User;

trait CommonTrait
{
    

    public function set_owner_id($userid) {
        $user = User::find($userid);
        if($user->position_id === 1) {
            return $user->id;
        } else {
            return $user->owner_id;
        }
    }
    
}
