<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stati;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_alias)
    {
//        dd($category);
        //Получаем текущую категорию
        $category = Category::where('alias', $category_alias)->first();
        $subcategories = Category::filters()->where('parent_id', '=', $category->id)
            ->where('status', '=', '1')
            ->defaultSort('id', 'asc')
            ->get();
        $stati = '';
        if ($category->stati){
            $stati = Stati::where('status', '=', '1')->whereIn('id', json_decode($category->stati))->get();
        }

        $category_id = $category->id;

        //Получаем все товары относящиеся к этой категории
        $products = Product::with('attachment')
            ->where('parent_id', $category_id)
            ->where('status', '=', '1')
            ->paginate(15);


        $category_children = Category::find($category_id)->descendantsAndSelf()->depthFirst()->get();



        $category_ids = [];
        foreach ($category_children as $item){
            $category_ids[] = $item->id;
        }

        $category_children_products = Product::whereIn('parent_id', $category_ids)
            ->inRandomOrder()
            ->with('attachment')
            ->where('status', '=', '1')
            ->paginate(15);
        if (!sizeof($subcategories)){
            $category_children_products = Product::whereIn('parent_id', $category_ids)
                ->with('attachment')
                ->where('status', '=', '1')
                ->paginate(15);
        }

        $napolnye_pokrytiia = Category::find(40)->descendantsAndSelf()->depthFirst()->get();
        $napolnye_pokrytiia_ids = [];
        foreach ($napolnye_pokrytiia as $item){
            $napolnye_pokrytiia_ids[] = $item->id;
        }

        $dveri_mass = Category::find(21)->descendantsAndSelf()->depthFirst()->get();
        $dveri_mass_ids = [];
        foreach ($napolnye_pokrytiia as $item){
            $dveri_mass_ids[] = $item->id;
        }

        //категория напольные покрытия
        $napolnye_pokrytiia_get = 0;
        if(in_array( $category_id ,$napolnye_pokrytiia_ids ) ||  in_array( $category_id ,$dveri_mass_ids ))
        {
            $napolnye_pokrytiia_get = 1;

            if (sizeof($subcategories)){
                $category_children_products = Product::whereIn('parent_id', $category_ids)
                    ->with('attachment')
                    ->inRandomOrder()
                    ->where('status', '=', '1')
                    ->paginate(16);
            }
        }

        //категория напольные покрытия
        return view('category/category',
            compact(
                'category',
                'products',
                'subcategories',
                'stati',
                'category_children_products',
                'napolnye_pokrytiia_get'
            ));

    }

}
