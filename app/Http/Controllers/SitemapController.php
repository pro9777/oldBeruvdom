<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Filesystem\Filesystem;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    public function index(){
        app(Filesystem::class)->delete(resource_path('views/sitemap/sitemap.blade.php'));
        SitemapGenerator::create(url('/'))->writeToFile(resource_path('views/sitemap/sitemap.blade.php'));
        return response()->view('sitemap/sitemap')->header('Content-Type', 'text/xml');
    }

    public function yandex(){
        $categories = Category::where('status', '=', '1') ->get();
        $products = Product::where('status', '=', '1') ->get();
        return response()->view('sitemap/yandex', compact('categories', 'products'))
            ->header('Content-Type', 'text/xml');
    }

    public function vk(){
        $categories = Category::where('status', '=', '1') ->get();
        $products = Product::where('status', '=', '1') ->get();
        return response()->view('sitemap/vk', compact('categories', 'products'))
            ->header('Content-Type', 'text/xml');
    }

    public function doors(){
        //подкатегории
        $categories = Category::find(21)->descendantsAndSelf()->depthFirst()->get();
        $categoryIds = $categories->pluck('id')->toArray();

        //товары
        $products = Product::whereIn('parent_id', $categoryIds)->get();
        return response()->view('sitemap/yandex2', compact('categories', 'products'))
            ->header('Content-Type', 'text/xml');
    }
}
