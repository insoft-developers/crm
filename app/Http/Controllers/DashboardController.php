<?php

namespace App\Http\Controllers;

use App\Models\NumberPrefix;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use CommonTrait;
    
    public function index() {
        
        $userid = $this->set_owner_id(Auth::user()->id);
        $cek = NumberPrefix::where('userid', $userid)->first();
        if($cek) {

        } else {
            NumberPrefix::create([
                "purchase_request" => "PR-ID-",
                "purchase_order" => "PO-ID-",
                "good_receive" => "GR-ID-",
                "titipan" => "TI-ID-",
                "userid" => $userid
            ]);
        }
        
        
        return view('frontend.dashboard.index');
    }
}
