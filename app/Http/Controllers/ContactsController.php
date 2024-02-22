<?php

namespace App\Http\Controllers;
use App\Models\Page;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(Request $request){
        $page = Page::where('alias', $request->path())->first();
        return view('contacts.contacts', compact('page'));
    }

    public function success(Request $request){
        $page = Page::where('alias', $request->path())->first();
        return view('contacts.success', compact('page'));
    }
}
