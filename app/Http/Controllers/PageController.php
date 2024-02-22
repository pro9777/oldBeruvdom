<?php

namespace App\Http\Controllers;


use App\Models\Page;

class PageController extends Controller
{
    public function index($alias){
        $page = Page::where('alias', $alias)->first();

        return view('page/page', compact('page'));
    }
}
