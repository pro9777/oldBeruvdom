<?php

namespace App\Http\Controllers;

use App\Models\Stati;
use Illuminate\Http\Request;

class StatiController extends Controller
{
    public function index(Request $request){
//        dd(Route::getCurrentRoute()->getPath());
        $stati = Stati::where('status', '=', '1')
            ->where('id', '!=', '11')
            ->orderBy('created_at', 'desc')->paginate(12);

        $statja = Stati::where('alias', $request->path())->first();

        return view('stati.stati', compact('statja', 'stati'));
    }

    public function statja($alias){
        $statja = Stati::where('alias', $alias)->first();

        return view('stati.statja', compact('statja'));
    }
}
