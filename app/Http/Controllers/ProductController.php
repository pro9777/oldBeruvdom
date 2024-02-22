<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use http\Env\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_alias, $product_alias)
    {

        $value = session('price_calculator');

//        dd($value);
//        session(['key' => 'value']);
//        session()->save();
//        dd(session()->all());

        //Получаем текущую категорию
        $category = Category::where('alias', $category_alias)
            ->with('calculator_group')
            ->where('status', '=', '1')
            ->first();
        //Получаем текущий товар
        $product = Product::where('alias', $product_alias)
            ->with(['attachment', 'calculator_group'])
            ->where('status', '=', '1')
            ->first();
//        dd($product);
        $product_photo = '';
        $product_gallery = '';
        $product_photo_background = '';

        if (!empty($product)) {
            $product_photo = $product->attachment()->where('group', 'product_photo')->get()[0] ?? '';
            $product_gallery = $product->attachment()->where('group', 'product_gallery')->get() ?? '';
            $product_photo_background = $product->attachment()->where('group', 'product_photo_background')->get()[0] ?? '';
        }

        $products_like = '';
        if (!empty($product->products_like)) {
            $products_like = Product::whereIn('id', json_decode($product->products_like) ?? [])->get();
        }


        //получаем к какой категории относится товар

        $firstParent = Category::find($category->id)->rootAncestor()->first();

//        dump($firstParent->id);
        if (!empty($firstParent)) {
            $firstParent = $firstParent->id;

        } else {
            $firstParent = $category->id;
        }

        return view('product/product', compact('category', 'product', 'products_like', 'product_photo', 'product_gallery', 'product_photo_background', 'firstParent'));
    }


}
