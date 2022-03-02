<?php

namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategories;

class NewsController extends Controller
{
    public function index(){
        $categories = NewsCategories::all();
        return view('public/news/index')->with([
            'categories' => $categories,
        ]);
    }
}
