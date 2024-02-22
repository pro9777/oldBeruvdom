<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
//        dd($request->get('query'));
        $query = trim($request->get('query'));
        if ($request->ajax()){
            if($query){
                $int2 = preg_replace('/^[CcСс]-/iu', '', $query);
                $products = Product::where('title', 'like', '%'. $query .'%')
                    ->orWhere('id', 'like', '%'. $int2 .'%')
                    ->orWhere('articular', 'like', '%'. $int2 .'%')
                    ->select(['id','title'])
                    ->get()
                    ->toArray();
                return json_encode($products);
            }
        }
//        dd($request->get('s'));
        $q = $request->get('s');
        $int2 = preg_replace('/^[CcСс]-/iu', '', $q);
        $products = Product::where('title', 'like', '%'. $q .'%')
            ->orWhere('id', 'like', '%'. $int2 .'%')
            ->with('category')
            ->paginate(15);


        return view('search.search', compact('products', 'q'));
    }
}
