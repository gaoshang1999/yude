<?php namespace App\Http\Controllers\My;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Courses;

class MyController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function order()
    {
        $data = ['course'=>Courses::where('id', 1)->first()];
        return view('my.orderit', $data);
    }

}
