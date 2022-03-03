<?php

namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategories;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if(!empty($request->cookie('pagination_count'))) {
            $paginationCount = $request->cookie('pagination_count');
        }else{
            $paginationCount = 10;
        }

        $categories = NewsCategories::all();

        if (!empty($request->cookie('category_filter'))) {
            $news = News::where(
                'category_id', '=', $request->cookie('category_filter')
            )->paginate($paginationCount);
        } else {
            $news = News::paginate($paginationCount);
        }

        return view('public/news/index')->with([
            'categories' => $categories,
            'arrNews' => $news,
        ]);
    }

    public function setCategory(Request $request)
    {
        return response(
            ['success' => true]
        )->cookie(
            'category_filter', // ключ
            $request->input('category'), // значение
            60,
        );
    }

    public function setPaginationCount(Request $request)
    {
        return response(
            ['success' => true]
        )->cookie(
            'pagination_count', // ключ
            $request->input('count'), // значение
            60,
        );
    }
}
