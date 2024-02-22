<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Home\Home;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $home = Home::find(1);

        $hits = Product::where('hits', '=', '1')
            ->where('status', '=', '1')
            ->with('category')
            ->get();

        $new = Product::where('new', '=', '1')
            ->where('status', '=', '1')
            ->limit(2)
            ->with(['category', 'attachment'])
            ->get();


//        dd($new2[0]->calculator_value);
//        foreach ($new as $k => $item){
//            dd($item->attachment()->where('group', 'product_gallery')->get()[0]->relativeUrl);
//        }
//        dd($new[0]->attachment()->where('group', 'product_gallery')->get()[0]->relativeUrl);

        return view('home.home', compact('home', 'hits', 'new'));
    }


}
