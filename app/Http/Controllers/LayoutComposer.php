<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Stati;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Models\Attachmentable;

class LayoutComposer
{
    public function compose(View $view)
    {
//        $categoryes_ = Category::get()->pluck('id');
//
//        dd(json_decode($categoryes_));


        $categoryes = Category::whereNull('parent_id')->where('status', '=', '1')->get();
        $route = Route::currentRouteName();
        $iser_id = session('_token');
        $page_header = Page::whereIn('id', [9, 5, 4 ,3])->get();
        session(['attributes' => '']);
        $view->with(compact('categoryes', 'route', 'iser_id', 'page_header'));
    }
}
